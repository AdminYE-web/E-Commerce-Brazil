<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionDependency extends Model
{
    protected $primaryKey = 'dependency_id';

    protected $fillable = [
        'parent_option_id',
        'child_option_id',
    ];

    public function parentOption()
    {
        return $this->belongsTo(ProductOption::class, 'parent_option_id', 'option_id');
    }

    public function childOption()
    {
        return $this->belongsTo(ProductOption::class, 'child_option_id', 'option_id');
    }
}