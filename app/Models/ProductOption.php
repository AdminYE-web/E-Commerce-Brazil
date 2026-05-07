<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $primaryKey = 'option_id';

    protected $fillable = [
        'option_group_id',
        'option_code',
        'option_name',
        'color_code',
        'option_detail',
        'additional_price',
        'price_type',
        'is_active',
    ];

    public function group()
    {
        return $this->belongsTo(OptionGroup::class, 'option_group_id', 'option_group_id');
    }

    public function images()
    {
        return $this->hasMany(OptionImage::class, 'option_id', 'option_id');
    }

    public function mainImage()
    {
        return $this->hasOne(OptionImage::class, 'option_id', 'option_id')
            ->where('is_main', 1);
    }
    public function childDependencies()
{
    return $this->hasMany(OptionDependency::class, 'parent_option_id', 'option_id');
}

public function parentDependencies()
{
    return $this->hasMany(OptionDependency::class, 'child_option_id', 'option_id');
}
public function productAssignments()
{
    return $this->hasMany(ProductOptionAssignment::class, 'option_id', 'option_id');
}

public function products()
{
    return $this->belongsToMany(
        Product::class,
        'product_option_assignments',
        'option_id',
        'product_id',
        'option_id',
        'product_id'
    )
    ->withPivot([
        'assignment_id',
        'sort_order',
        'is_default',
        'is_active',
    ])
    ->withTimestamps();
}
public function variants()
{
    return $this->hasMany(ProductOptionVariant::class, 'option_id', 'option_id')
        ->where('is_active', 1)
        ->orderBy('sort_order');
}

public function defaultVariant()
{
    return $this->hasOne(ProductOptionVariant::class, 'option_id', 'option_id')
        ->where('is_active', 1)
        ->orderBy('is_default', 'desc')
        ->orderBy('sort_order');
}
}