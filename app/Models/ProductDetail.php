<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $primaryKey = 'product_detail_id';

    protected $fillable = [
        'product_id',
        'sample_image',
        'detail_content',
        'is_active',
    ];
    protected $casts = [
    'detail_content' => 'array',
];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    
}