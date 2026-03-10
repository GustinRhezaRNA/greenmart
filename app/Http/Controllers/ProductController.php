<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::with('descriptions')->get();
        return view('product', compact('products'));
    }

    public function store(ProductStoreRequest $request)
    {
        $this->productService->createProducts($request->validated('products'));
        return back()->with('success', 'Product saved');
    }

}
