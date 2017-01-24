<?php

namespace App\Http\Commons;

use Exception;
use Predis\Client;

class Redis
{
    private $redis;

    public function __construct($config)
    {
        $redis = new Client($config);
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
        $key = $this->getKey($key);
        $value['slw_timeout'] = $second;
        $value['slw_key'] = $key;
        $this->redis->set($key, serialize($value));
        $this->redis->expire($key, $second);
    }

    public function getList($key)
    {
        return $this->redis->keys($key . '-*');
    }

    public function getListRead($key)
    {
        return $this->redis->keys('read/' . $key . '-*');
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
     * @author Zhou Yu
     */
    public function softDel($key)
    {
        $result = unserialize($this->redis->get($key));
        $this->redis->del($key);

        $this->redis->set('read/' . $key, serialize($result));
        $this->redis->expire($key, $result['slw_timeout']);
    }

    public function flushDb()
    {
        $this->redis->flushdb();
    }
}
