<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{

    protected $fillable = [
        'product_id',
        'description',
        'image'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
