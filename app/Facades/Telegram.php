<?php

namespace App\Facades;

/**
 * @method static send(string $text)
 * @method static sendToManager(string $text)
 */
class Telegram extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'telegram.service';
    }
}
