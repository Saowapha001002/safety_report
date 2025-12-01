<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SafetyReportMail extends Mailable implements ShouldQueue
{
     use Queueable, SerializesModels;

    public string $viewName;
    public array $data;              // 👈 เปลี่ยนชื่อ ไม่ใช้ viewData แล้ว
    public array $attachmentsList;

    /**
     * @param string $subject
     * @param string $viewName  เช่น 'mails.notify_assign_edit'
     * @param array  $data      ข้อมูลส่งเข้า view
     * @param array  $attachmentsList path ไฟล์แนบ
     */
    public function __construct(
        string $subject,
        string $viewName,
        array $data = [],
        array $attachmentsList = []
    ) {
        $this->subject($subject);
        $this->viewName        = $viewName;
        $this->data            = $data;
        $this->attachmentsList = $attachmentsList;
    }

    public function build()
    {
        // ใช้ $this->data ส่งเข้า view
        $email = $this->view($this->viewName, $this->data);

        foreach ($this->attachmentsList as $file) {
            if (is_string($file) && file_exists($file)) {
                $email->attach($file);
            }
        }

        return $email;
    }
    
}
