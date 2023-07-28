<?php

namespace App\Components\helpers;

class Telegram {

    public function send(string $text): bool {
        return $this->sendMessage(
            config('user.site-name') . "\nEnv: "
                . env('APP_ENV') . '(' . env('APP_URL') . ")\n" . $text,
            env('TELEGRAM_CHAT_ID_DEVELOPER')
        );
    }

    public function sendToManager(string $text): bool {
        return $this->sendMessage(
            (env('APP_ENV') == 'dev' ? '!! Это тестовая байда с локального ресурса' : '') . "\n" . $text,
            env('TELEGRAM_CHAT_ID_MANAGER')
        );
    }

    protected function sendMessage($text, $chatId): bool {
        $ch = curl_init();

        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . env('TELEGRAM_TOKEN') . '/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    'chat_id' => $chatId,
                    'text' => $text,
                ),
            )
        );

        curl_exec($ch);

        return true;
    }

}
