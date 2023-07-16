<?php

namespace App\Components\helpers;

class Telegram {

    public static function send($text) {
        $ch = curl_init();

        $text = config('user.site-name') . "\n" . $text;

        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . env('TELEGRAM_TOKEN') . '/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => $text,
                ),
            )
        );

        curl_exec($ch);
    }

}
