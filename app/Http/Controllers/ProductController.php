<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDescription;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('descriptions')->get();
        return view('product', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array|max:5',
            'products.*.name' => 'required|string',
            'products.*.descriptions' => 'required|array|max:3',
            'products.*.descriptions.*.text' => 'required|string',
            'products.*.descriptions.*.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'products.*.descriptions.*.image.mimes' => 'File harus berupa JPG, JPEG, atau PNG',
        ]);

        foreach ($request->products as $productData) {

            $product = Product::create([
                'name' => $productData['name']
            ]);

            if (isset($productData['descriptions'])) {

                foreach ($productData['descriptions'] as $desc) {

                    $imagePath = null;

                    if (isset($desc['image'])) {

                        $imagePath = $desc['image']
                            ->store('products', 'public');
                    }

                    ProductDescription::create([

                        'product_id' => $product->id,

                        'description' => $desc['text'],

                        'image' => $imagePath

                    ]);
                }
            }
        }

        return back()->with('success', 'Product saved');

    }

}
