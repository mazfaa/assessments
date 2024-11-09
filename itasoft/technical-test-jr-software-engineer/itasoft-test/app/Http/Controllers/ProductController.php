<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list-product|create-product|edit-product|delete-product', only: ['index', 'show']),
            new Middleware('permission:create-product', ['only' => ['create','store']]),
            new Middleware('permission:edit-product', ['only' => ['edit','update']]),
            new Middleware('permission:delete-product', ['only' => ['destroy']]),
        ];
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function getData()
    {
        $products = Product::select(['id', 'name', 'price', 'stock', 'created_at']);

        return DataTables::of($products)
            ->addColumn('action', function ($product) {
                return '
                    <a href="'.route('products.edit', $product->id).'" class="btn btn-sm btn-warning">Edit</a>
                    <form action="'.route('products.destroy', $product->id).'" method="POST" style="display:inline;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        Product::create($request->all());
        alert()->success('Success','Product Created Successfully!');
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());
        alert()->success('Success','Product Edited Successfully!');
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        alert()->success('Success','Product Deleted Successfully!');
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
