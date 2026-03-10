<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductDescription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function createProducts(array $productsData)
    {
        return DB::transaction(function () use ($productsData) {
            foreach ($productsData as $data) {
                $product = Product::create(['name' => $data['name']]);
                $this->attachDescriptions($product, $data['descriptions'] ?? []);
            }
            return true;
        });
    }

    private function attachDescriptions(Product $product, array $descriptions)
    {
        foreach ($descriptions as $desc) {
            $imagePath = isset($desc['image'])
                ? $desc['image']->store('products', 'public')
                : null;

            ProductDescription::create([
                'product_id' => $product->id,
                'description' => $desc['text'],
                'image' => $imagePath
            ]);
        }
    }

    public function deleteProduct(Product $product)
    {
        return DB::transaction(function () use ($product) {
            foreach ($product->descriptions as $desc) {
                if ($desc->image) {
                    Storage::disk('public')->delete($desc->image);
                }
            }
            return $product->delete();
        });
    }
}
