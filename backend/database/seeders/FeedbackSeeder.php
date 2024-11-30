<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        DB::table('feedbacks')->insert([
            [
                'user_id' => 1,
                'full_name' => 'Nguyễn Văn C',
                'email' => 'nguyenvanc@example.com',
                'phone_number' => '0911223344',
                'feedback_type' => 'Đánh giá',
                'subject' => 'Dịch vụ tuyệt vời',
                'message' => 'Tôi rất hài lòng với dịch vụ của shop!',
                'rating' => 5,
                'status' => 'Đã xử lý',
                'date_submitted' => now(),
            ],
            [
                'user_id' => null,
                'full_name' => 'Phạm Thị D',
                'email' => 'phamthid@example.com',
                'phone_number' => '0988776655',
                'feedback_type' => 'Cảm nhận',
                'subject' => 'Trải nghiệm mua sắm',
                'message' => 'Tôi có trải nghiệm tốt khi mua hàng.',
                'rating' => 4,
                'status' => 'Đã xử lý',
                'date_submitted' => now(),
            ],
        ]);
    }
}
