<?php

namespace App\Http\Controllers;

// use App\Jobs\SendScheduledEmail;
use App\Mail\CustomEmail;
// use App\Models\ScheduledEmail;
use App\Models\User;
// use Carbon\Carbon;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function viewEmail()
    {
        $userEmail = User::select('id', 'username', 'email')->get();
        return view('admin.emails.viewEmail', compact('userEmail'));
    }

    public function sendEmail(Request $request)
    {
        $toEmail = $request->input('toEmail');
        $subject = $request->input('subject');
        $message = $request->input('message');
        $scheduleDate = $request->input('scheduleDate');

        if (is_string($toEmail)) {
            $toEmail = array_map('trim', explode(',', $toEmail));
        }

        if ($scheduleDate) {
            // Lưu vào bảng `scheduled_emails`
            DB::table('scheduled_emails')->insert([
                'to_email' => json_encode($toEmail),
                'subject' => $subject,
                'message' => $message,
                'schedule_date' => $scheduleDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Artisan::call('email:send-scheduled');
            return redirect()->back()->with('success', 'Email đã được lên lịch!');
        } else {
            // Gửi ngay lập tức
            foreach ($toEmail as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    Mail::send(new CustomEmail($subject, $message, $email));
                } else {
                    return redirect()->back()->with('error', "Địa chỉ email không hợp lệ: $email");
                }
            }

            return redirect()->back()->with('success', 'Email đã được gửi thành công!');
        }
    }
}
