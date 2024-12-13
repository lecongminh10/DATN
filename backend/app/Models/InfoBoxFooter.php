<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoBoxFooter extends Model
{
    use HasFactory;
    
    protected $table = 'info_boxes_footer';

    protected $fillable = [
        'title_1',
        'title_2',
        'title_3',
        'sub_title_1',
        'sub_title_2',
        'sub_title_3',
        'description_support',
        'description_payment',
        'description_return',
        'created_at',
        'updated_at'
    ];
}
