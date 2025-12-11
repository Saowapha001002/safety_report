<?php

namespace App\Helpers;

use App\Mail\SafetyReportMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailHelper
{
    /**
     * ส่งเมล Safety-Report แบบ queue
     *
     * @param array|string $to   อีเมลปลายทาง (string หรือ array)
     * @param array|string $cc   CC (optional)
     * @param array|string $bcc  BCC (optional)
     * @param string       $subject หัวข้อเมล
     * @param string       $view   view name เช่น 'emails.safety.report'
     * @param array        $viewData  ตัวแปรส่งเข้า view
     * @param array        $attachments  array ของ path ที่จะแนบ
     */
    public static function queueSafetyMail(
        $to,
        string $subject,
        string $view,
        array $viewData = [],
        array $attachments = [],
        $cc = null,
        $bcc = null
    ): bool {
        try {
            $mailable = new SafetyReportMail($subject, $view, $viewData, $attachments);

            $mailer = Mail::to($to);

            if (!empty($cc)) {
                $mailer->cc($cc);
            }

            if (!empty($bcc)) {
                $mailer->bcc($bcc);
            }

            // ส่งแบบ queue
            $mailer->queue($mailable);

            return true;
        } catch (\Throwable $e) {
            Log::error('MailHelper queueSafetyMail error', [
                'error' => $e->getMessage(),
                'to'    => $to,
                'cc'    => $cc,
                'bcc'   => $bcc,
            ]);
            return false;
        }
    }


    /**
     * ====== ฟังก์ชันเดิม (ยิง API ภายนอก) เก็บไว้ใช้ต่อได้ ======
     */
    public static function sendExternalMail($sToEmail, $sMailTitle, $view, $viewData, $sFrom)
    {
        $sUrl = 'https://user-request.bgiglass.com/user_request/?r=API/Mail';

        $sMailDescription = view($view, $viewData)->render();

        $aData = [
            'sToEmail'     => $sToEmail,
            'sSubject'     => $sMailTitle,
            'sDescription' => $sMailDescription,
            'sFrom'        => $sFrom,
        ];

        $oCh = curl_init($sUrl);
        curl_setopt_array($oCh, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $aData,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 10,
        ]);

        $response = curl_exec($oCh);
        $error    = curl_error($oCh);
        curl_close($oCh);

        if ($error) {
            // Log::error('SendMail Error', [...]);
            return false;
        }

        return $response;
    }
}
