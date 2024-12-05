<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerMain extends Model
{
    use HasFactory;
    protected $table = 'banner_main';

    protected $fillable = [
        'title',
        'sub_title',
        'image',
        'price',
        'title_button',
        'created_at',
        'updated_at'
    ];
}
