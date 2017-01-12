<?php

namespace App\Http\Commons;

use Exception;
use Predis\Client;

class Redis
{
    public $redis;

    public function __construct()
    {
        $redis = new Client();
        $redis->auth(config('database.redis.default.password'));
        $redis->select(config('database.redis.default.database'));
        $this->redis = $redis;
    }

    public function getConnection()
    {
        return $this->redis;
    }

    private function getKey($key)
    {
        return $key . '-' . microtime(true);
    }

    public function set($key, $value, $second)
    {
        if (! is_array($value)) {
            throw new Exception('Cache 必须使用数组');
        }
        $value['slw_timeout'] = $second;
        $key = $this->getKey($key);
        $this->redis->set($key, serialize($value));
        $this->redis->expire($key, $second);
    }

    public function getList($key)
    {
        return $this->redis->keys($key . '-*');
    }

    /**
     *
     *
     * @param $key '未加工'
     * @return mixed
     * @author Zhou Yu
     */
    public function get($key)
    {
        $result = unserialize($this->redis->get($key));
        unset($result['slw_timeout']);
        return $result;
    }

    /**
     * 从 key 转换到 read/key, 实现已阅
     *
     * @param $key '未加工'
     * @return mixed
     * @author Zhou Yu
     */
    public function pull($key)
    {
        $result = unserialize($this->redis->get($key));
        $this->redis->del($key);

        $this->redis->set('read/' . $key, serialize($result));
        $this->redis->expire($key, $result['slw_timeout']);
        unset($result['slw_timeout']);

        return $result;
    }
}
