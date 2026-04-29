<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionGroup extends Model
{
    protected $primaryKey = 'option_group_id';

    protected $fillable = [
        'group_code',
        'group_name',
        'is_required',
        'is_active',
    ];

    public function options()
    {
        return $this->hasMany(ProductOption::class, 'option_group_id', 'option_group_id');
    }
}
