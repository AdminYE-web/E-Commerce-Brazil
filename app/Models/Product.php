<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;

class Product extends Model
{
    protected $primaryKey = 'product_id';

   protected $fillable = [
    'product_code',
    'category_id',
    'material_id',
    'product_name',
    'description',
    'is_antivirus_included',
    'is_active',
];
    public function priceTiers()
    {
        return $this->hasMany(ProductPriceTier::class, 'product_id', 'product_id');
    }
 public function mainImage()
{
    return $this->hasOne(ProductImage::class, 'product_id', 'product_id')
        ->where('image_type', 'main')
        ->where('is_main', 1);
}

public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
}
public function detailImages()
{
    return $this->hasMany(ProductImage::class, 'product_id', 'product_id')
        ->where('image_type', 'detail')
        ->orderBy('sort_order');
}
public function detail()
{
    return $this->hasOne(ProductDetail::class, 'product_id', 'product_id');
}
public function category()
{
    return $this->belongsTo(Category::class, 'category_id', 'category_id');
}

public function material()
{
    return $this->belongsTo(Material::class, 'material_id', 'material_id');
}
}
