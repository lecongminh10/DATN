<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class CustomEmail extends Mailable
{
    public $subject;
    public $message;
    public $toEmail;

    /**
     * CustomEmail constructor.
     *
     * @param string $subject
     * @param string $message
     * @param string $toEmail
     */
    public function __construct($subject, $message, $toEmail)
    {
        // Set subject and message from the constructor
        $this->subject = $subject;
        $this->message = $message;
        $this->toEmail = $toEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Tạo nội dung HTML trực tiếp
        $content = view('admin.emails.custom_email', [
            'message' => $this->message,
            'subject' => $this->subject,
        ])->render();
    
        return $this->subject($this->subject)
                    ->to($this->toEmail)
                    ->html($content); // Sử dụng phương thức html() để gửi nội dung email
    }
    

}
