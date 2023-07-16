<?php

namespace Tests;

use App\Components\helpers\Telegram;
use App\Models\BlogArticle;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static $initialized = 0;

    public function setUp(): void {

        parent::setUp();

        if (!self::$initialized) {
/*            $user = new User([
                'name' => 'admin',
                'email' => 'yyyyyy@gmail.com',
                'password' => '12345678'
            ]);
            $user->save();

            $token = $user->createToken(1)->plainTextToken;*/

            self::$initialized = 1;
        }
    }
}
