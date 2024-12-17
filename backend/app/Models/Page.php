<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'pages';

    protected $fillable = [
        'name',
        'permalink',
        'description',
        'content',
        'is_active',
        'template',
        'seo_title',
        'seo_description',
        'deleted_at',
        'image'
    ];
}
