<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDescription;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        return view('product');
    }

    public function store(Request $request)
    {

        foreach ($request->products as $productData) {

            $product = Product::create([
                'name' => $productData['name']
            ]);

            if(isset($productData['descriptions'])){

                foreach ($productData['descriptions'] as $desc){

                    $imagePath = null;

                    if(isset($desc['image'])){

                        $imagePath = $desc['image']
                            ->store('products','public');
                    }

                    ProductDescription::create([

                        'product_id' => $product->id,

                        'description' => $desc['text'],

                        'image' => $imagePath

                    ]);
                }
            }
        }

        return back()->with('success','Product saved');

    }

}
