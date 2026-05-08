<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;
use App\Models\ProductPriceTier;

class Product extends Model
{
    protected $primaryKey = 'product_id';

   protected $fillable = [
    'product_code',
    'category_id',
    'material_id',
      'product_type',
    'product_name',
    'description',
    'is_antivirus_included',
    'is_active',
];
    public function priceTiers()
{
    return $this->hasMany(ProductPriceTier::class, 'product_id', 'product_id')
        ->where('is_active', 1)
        ->orderBy('min_qty');
}
public function mainImage()
{
    return $this->hasOne(ProductImage::class, 'product_id', 'product_id')
        ->where('image_type', 'main')
        ->orderBy('is_main', 'desc')
        ->orderBy('sort_order');
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
public function galleryImages()
{
    return $this->hasMany(ProductImage::class, 'product_id', 'product_id')
        ->where('image_type', 'gallery')
        ->orderBy('sort_order');
}
public function optionAssignments()
{
    return $this->hasMany(ProductOptionAssignment::class, 'product_id', 'product_id');
}

public function assignedOptions()
{
    return $this->belongsToMany(
        ProductOption::class,
        'product_option_assignments',
        'product_id',
        'option_id',
        'product_id',
        'option_id'
    )
    ->withPivot([
        'assignment_id',
        'sort_order',
        'is_default',
        'is_active',
    ])
    ->withTimestamps();
}
public function priceRules()
{
    return $this->hasMany(ProductPriceRule::class, 'product_id', 'product_id')
        ->where('is_active', 1)
        ->orderBy('sort_order');
}
}
