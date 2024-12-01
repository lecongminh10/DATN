<?php
namespace App\Console\Commands;

use App\Jobs\SendScheduledEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendScheduledEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi email theo lịch trình dựa trên ngày lên lịch';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Log thông báo bắt đầu
        Log::info('Bắt đầu gửi email theo lịch trình');

        $scheduledEmails = DB::table('scheduled_emails')
            ->where('schedule_date', '<', Carbon::now()->toDateTimeString()) // Thay dấu = thành <
            ->where('status', 'pending')
            ->get();

        if ($scheduledEmails->isEmpty()) {
            Log::info('Không có email nào cần gửi theo lịch trình.');
        }

        foreach ($scheduledEmails as $email) {
            try {
                // Dispatch job để gửi email
                SendScheduledEmail::dispatch(
                    json_decode($email->to_email, true), // Chuyển đổi JSON thành mảng email
                    $email->subject,
                    $email->message,
                    $email->schedule_date
                );

                // Log thông tin email đã gửi
                Log::info('Đã gửi email đến: ' . json_decode($email->to_email, true)[0]);

                // Cập nhật trạng thái email thành "sent"
                DB::table('scheduled_emails')
                    ->where('id', $email->id)
                    ->update(['status' => 'sent']);

                Log::info('Đã cập nhật trạng thái email với ID ' . $email->id . ' thành "sent".');
            } catch (\Exception $e) {
                // Log lỗi nếu có
                Log::error('Lỗi khi gửi email với ID ' . $email->id . ': ' . $e->getMessage());
            }
        }

        $this->info('Email theo lịch trình đã được gửi thành công!');
        Log::info('Kết thúc quá trình gửi email theo lịch trình.');
    }
}
