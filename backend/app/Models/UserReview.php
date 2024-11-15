<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    use HasFactory;

    protected $table = 'users_reviews';

    protected $fillable = [
        'user_id', 
        'product_id', 
        'rating', 
        'review_text', 
        'review_date', 
        'images', 
        'videos', 
        'is_verified', 
        'helpful_count', 
        'reply_text', 
        'reply_date', 
        'deleted_at', 
        'deleted_by', 
        'created_at', 
        'updated_at'
    ];
}
