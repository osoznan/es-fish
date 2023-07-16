<?php

namespace App\Components\helpers;

class Mail {

    const ADMIN_EMAIL = 'yuoanswami@gmail.com';

    public static function send($to, $subject, $message, $headers) {
        $res = mail($to, $subject, $message, $headers);

        if ($res) {
            return true;
        }

    }

    public static function sendMailToAdmin($subject, $message) {
        $to = static::ADMIN_EMAIL;
        $from = config('admin-email') . $to;
        $subject .= ' - ' . config('site-name');

        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset="utf-8"',
            'From' => $from,
            'Reply-To' => $from,
            'X-Mailer' => 'PHP/' . phpversion()
        ];

        $res = static::send($to, $subject, $message, join("\r\n", $headers));

        // $res = static::send('yuoanswami@gmail.com', $subject, $message, join("\r\n", $headers));

        return $res;
    }

}
