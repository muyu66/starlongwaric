<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $baseUrl = 'http://www.slw.app';

    const UNIT_EMAIL = 'zhouyu@muyu.party';
    const UNIT_PASSWORD = '111111';
    const UNIT_ID = '2';
    const UNIT_BASIC_AUTH = 'Basic emhvdXl1QG11eXUucGFydHk6MTExMTEx';

    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        Artisan::call('database:create');
        return $app;
    }

    public function login()
    {
        Auth::loginUsingId(static::UNIT_ID);
    }

    public function get($uri, array $data = [], array $headers = [])
    {
        $headers['Accept'] = 'Application/json';
        $uri .= '?' . http_build_query($data, null, '&');
        return parent::get($uri, $headers);
    }

    public function get_with_login($uri, array $data = [], array $headers = [])
    {
        $headers['Authorization'] = self::UNIT_BASIC_AUTH;
        return $this->get($uri, $data, $headers);
    }

    public function post($uri, array $data = [], array $headers = [])
    {
        $headers['Accept'] = 'Application/json';
        return parent::post($uri, $data, $headers);
    }

    public function post_with_login($uri, array $data = [], array $headers = [])
    {
        $headers['Authorization'] = self::UNIT_BASIC_AUTH;
        return $this->post($uri, $data, $headers);
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
