<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Http\Requests\TransactionRequest;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;

class TransactionController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return [
      new Middleware('permission:list-transaction|create-transaction|edit-transaction|delete-transaction', only: ['index', 'show']),
      new Middleware('permission:create-transaction', ['create', 'store']),
      new Middleware('permission:edit-transaction', ['update', 'edit']),
      new Middleware('permission:delete-transaction', ['destroy']),
    ];
  }

  public function export()
  {
    return Excel::download(new TransactionsExport, 'transactions.xlsx');
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    if (auth()->user()->hasRole('admin')) {
      // Jika Admin, tampilkan semua transaksi
      $transactions = Transaction::with('user')->get();
    } else {
      // Jika bukan Admin, tampilkan hanya transaksi milik user yang login
      $transactions = Transaction::with('user')
        ->where('user_id', auth()->user()->id)
        ->get();
    }
    return view('transaction.index', compact('transactions'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $user = '';
    $users = '';

    if (auth()->user()->hasRole('admin')) {
      $users = User::whereHas('roles', function ($query) {
        $query->where('name', 'customer');
      })->get();
    } else {
      $user = User::findOrFail(auth()->user()->id);
    }

    if (Auth::user()->bought_1a) {
      $products = Product::all();
    } else {
      $products = Product::where('category', '1a')->latest()->get();
    }

    return view('transaction.create', compact('products', 'users', 'user'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    foreach ($request->products as $index => $product) {
      $product = Product::find($product['id']);
      if ($request->products[$index]['quantity'] > $product['stock']) {
        return redirect()->back()->with('error', 'Stok product ' . $product['name'] . 'tidak cukup');
      }
    }
    // dd($request->all());
    $request->validate([
      'user_id' => 'required',
      'products' => 'required|array',
      'products.*.id' => 'exists:products,id',
      'products.*.quantity' => 'required|integer|min:1',
    ]);

    $transaction = Transaction::create([
      'code' => date('Y-m') . '-000' . (Transaction::count() + 1),
      'user_id' => $request->user_id,
      'total_quantity' => 0,
      'total_price' => 0,
    ]);

    $totalQuantity = 0;
    $totalPrice = 0;

    foreach ($request->products as $productData) {
      $product = Product::find($productData['id']);
      $quantity = $productData['quantity'];
      $price = $product->price * $quantity;

      TransactionDetail::create([
        'transaction_id' => $transaction->id,
        'product_id' => $product->id,
        'quantity' => $quantity,
        'price' => $price,
      ]);

      $product->category == '1a' ? Auth::user()->bought_1a = true : Auth::user()->bought_1b = true;

      Auth::user()->save();

      $totalQuantity += $quantity;
      $totalPrice += $price;
      $product->stock -= $quantity;
      $product->save();
    }

    $transaction->update(['total_quantity' => $totalQuantity, 'total_price' => $totalPrice]);
    alert()->success('Success', 'Transaction Successfull');
    return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Transaction $transaction)
  {
    $transaction = Transaction::findOrFail($transaction->id);
    $transaction_item = TransactionDetail::with(['user', 'product'])->whereTransactionId($transaction->id)->get();
    return view('transaction.item', compact('transaction', 'transaction_item'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Transaction $transaction)
  {
    Transaction::with(['products', 'transactionDetails', 'user'])->findOrFail($transaction->id);
    // dd($transaction->products);
    $products = Product::all();
    return view('transaction.edit', compact('transaction', 'products'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Transaction $transaction)
  {
    $request->validate([
      'products' => 'required|array',
      'products.*.id' => 'exists:products,id',
      'products.*.quantity' => 'required|integer|min:1',
    ]);

    $totalQuantity = 0;
    $totalPrice = 0;

    $transaction->transactionDetails()->delete();

    foreach ($request->products as $productData) {
      $product = Product::find($productData['id']);
      $quantity = $productData['quantity'];
      $price = $product->price * $quantity;

      $transaction->transactionDetails()->create([
        'product_id' => $product->id,
        'quantity' => $quantity,
        'price' => $price,
      ]);

      $totalQuantity += $quantity;
      $totalPrice += $price;
    }

    $transaction->update(['total_quantity' => $totalQuantity, 'total_price' => $totalPrice]);
    alert()->success('Success', 'Transaction Edited Successfully');
    return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Transaction $transaction)
  {
    $transaction->delete();
    alert()->success('Success', 'Transaction Deleted Successfully');
    return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
  }
}
