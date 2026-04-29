<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_code',
        'product_name',
        'description',
        'is_antivirus_included',
        'is_active',
    ];

    public function priceTiers()
    {
        return $this->hasMany(ProductPriceTier::class, 'product_id', 'product_id');
    }
}
