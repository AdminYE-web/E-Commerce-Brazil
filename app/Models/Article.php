<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $primaryKey = 'article_id';

    protected $fillable = [
        'title',
        'category',
        'article_date',
        'detail',
        'cover_image',
        'is_active',
    ];
}