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
}