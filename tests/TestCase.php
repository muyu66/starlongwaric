<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $baseUrl = 'http://127.0.0.1:10000';

    const UNIT_EMAIL = 'zhouyu@muyu.party';
    const UNIT_PASSWORD = '111111';
    const UNIT_ID = '2';

    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        Artisan::call('database:create');
        return $app;
    }

    public function login($user_id = 0)
    {
        Auth::loginUsingId($user_id ? : self::UNIT_ID);
    }

    public function get($uri, array $data = [], array $headers = [])
    {
        $headers['Accept'] = 'Application/json';
        $uri .= '?' . http_build_query($data, null, '&');
        return parent::get($uri, $headers);
    }

    public function post($uri, array $data = [], array $headers = [])
    {
        $headers['Accept'] = 'Application/json';
        return parent::post($uri, $data, $headers);
    }

    public function see($texts, $negate = false)
    {
        if (is_array($texts)) {
            foreach ($texts as $text) {
                parent::see($text, $negate);
            }
        } else {
            parent::see($texts, $negate);
        }
    }
}
