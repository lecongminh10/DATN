<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Định nghĩa tên bảng (nếu tên bảng không phải dạng số nhiều của tên model)
    protected $table = 'feedbacks';

    // Định nghĩa khóa chính của bảng
    protected $primaryKey = 'feedback_id';

    // Khai báo các trường có thể được gán (mass assignable)
    protected $fillable = [
        'user_id', 
        'full_name', 
        'email', 
        'phone_number', 
        'feedback_type', 
        'subject', 
        'message', 
        'rating', 
        'date_submitted', 
        'status', 
        'admin_response', 
        'response_date', 
        'attachment_url'
    ];

    // Khai báo các trường không thể được gán (guarded) - nếu cần
    // protected $guarded = [];

    // Quan hệ với bảng users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Phương thức trả về trạng thái phản hồi
    public function getStatusAttribute($value)
    {
        $statuses = [
            'Chưa xử lý' => 'Chưa xử lý',
            'Đang xử lý' => 'Đang xử lý',
            'Đã xử lý' => 'Đã xử lý'
        ];
        return $statuses[$value] ?? 'Không xác định';
    }

    // Phương thức trả về loại phản hồi
    public function getFeedbackTypeAttribute($value)
    {
        $types = [
            'Góp ý' => 'Góp ý',
            'Khiếu nại' => 'Khiếu nại',
            'Đánh giá' => 'Đánh giá',
            'Cảm nhận' => 'Cảm nhận'
        ];
        return $types[$value] ?? 'Không xác định';
    }

    // Phương thức để lấy định dạng thời gian gửi phản hồi
    public function getDateSubmittedAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    // Phương thức để lấy định dạng thời gian phản hồi của admin
    public function getResponseDateAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('d-m-Y H:i:s') : null;
    }
}
