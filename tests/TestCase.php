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
    const UNIT_FLEET_ID = '2';
    const UNIT_BASIC_AUTH = 'Basic emhvdXl1QG11eXUucGFydHk6MTExMTEx';

    const UNIT_QINIU_BUCKET = 'starlongwaric-unit';

    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        Artisan::call('database:create');
        return $app;
    }

    /**
     * 反射私有方法 Beta
     *
     * @param string $class 类名
     * @param string $func 方法名
     * @param null $params 参数
     * @return mixed
     * @author Zhou Yu
     */
    public function getPrivate(string $class, string $func, $params = null)
    {
        if (! is_array($params)) {
            $params = [$params];
        }

        $ctl = new ReflectionMethod($class, $func);
        $ctl->setAccessible(true);
        return $ctl->invokeArgs(new $class(), $params);
    }

    public function assertException($func, $code)
    {
        try {
            $func();
            $result = false;
        } catch (Exception $e) {
            if ($e->getCode() === $code) {
                $result = true;
            } else {
                $result = false;
            }
        }
        $this->assertTrue($result);
    }

    public function login($user_id = null)
    {
        if (! $user_id) {
            $user_id = static::UNIT_ID;
        }
        Auth::loginUsingId($user_id);
    }

    public function get($uri, array $data = [], array $headers = [])
    {
        $headers['Accept'] = 'application/json';
        $uri .= '?' . http_build_query($data, null, '&');
        return parent::get($uri, $headers);
    }

    public function get_with_login($uri, array $data = [], array $headers = [])
    {
        $headers['Authorization'] = self::UNIT_BASIC_AUTH;
        return $this->get($uri, $data, $headers);
    }

    public function existUri($uri)
    {
        if (fopen($uri, 'r')) {
            return true;
        }
        return false;
    }

    public function post($uri, array $data = [], array $headers = [])
    {
        $headers['Accept'] = 'application/json';
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
