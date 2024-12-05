<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerExtra extends Model
{
    use HasFactory;
    protected $table = 'banner_extra';

    protected $fillable = [
        'title_1',
        'title_2',
        'title_3',
        'image_1',
        'image_2',
        'image_3',
        'price_1',
        'price_2',
        'price_3',
        'title_button_1',
        'title_button_2',
        'title_button_3',
        'created_at',
        'updated_at'
    ];
}
