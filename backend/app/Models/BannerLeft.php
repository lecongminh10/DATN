<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerLeft extends Model
{
    use HasFactory;

    protected $fillable = [
        'image','title', 'sub_title', 'sale', 'description', 'active'
    ];
}

