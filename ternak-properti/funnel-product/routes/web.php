<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\TransactionController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  $products_count = Product::select('id')->count();
  $product_stocks = Product::select('stock')->sum('stock');
  $customers_count = User::select('id')->count() - 1;
  $transactions_count = Transaction::select('id')->count();
  return view('dashboard', compact('products_count', 'product_stocks', 'customers_count', 'transactions_count'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
  Route::resource('products', ProductController::class)->middleware('auth');
  Route::get('/products-data', [ProductController::class, 'getData'])->name('products.data');

  Route::get('/transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
  Route::resource('transactions', TransactionController::class)->middleware('auth');

  Route::get('/summary', [SummaryController::class, 'index'])->name('summary.index')->middleware('role:admin');
  Route::get('/summary/export', [SummaryController::class, 'export'])->name('summary.export');

  Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index')->middleware('role:admin');
  Route::post('/approve-approval/{user}', [ApprovalController::class, 'approve'])->name('approval.approve');
  Route::post('/reject-approval/{user}', [ApprovalController::class, 'reject'])->name('approval.reject');
  Route::post('/request-approval', [ApprovalController::class, 'request'])->name('approval.request');

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test', function () {
  dd(Auth::user()->bought_1b);
});

require __DIR__ . '/auth.php';