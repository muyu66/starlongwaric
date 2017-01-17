<?php

namespace App\Http\Components;

use App\Http\Commons\Redis;
use App\Http\Controllers\FriendController;

class Message
{
    private $redis;

    public function __construct()
    {
        $this->redis = new Redis();
    }

    public function pushMessage($from_id, $to_id, $content)
    {
        $this->redis->set($to_id, [
            'content' => $content,
            'from' => $from_id,
            'to' => $to_id,
            'button' => 'read',
        ], 1296000); // 消息保存15天
    }

    public function pushMessageFunc($from_id, $to_id, $func_id)
    {
        $timeout = 1296000; // 消息保存15天

        switch ($func_id) {
            case 1:
                $content = 'xx 想成为你的伙伴';
                $button = 'yes_or_no';
                break;
            default:
                throw new \Exception('没有此功能消息');
        }

        $this->redis->set($to_id, [
            'content' => $content,
            'from' => $from_id,
            'to' => $to_id,
            'button' => $button,
            'func_id' => $func_id,
        ], $timeout);
    }

    public function resolveMessageFunc($func_id, $my_id, $friend_id, $key)
    {
        $result = $this->redis->get($key);

        if ($result['from'] !== $friend_id) {
            throw new \Exception('数据不合法, 超出权限');
        }
        if ($result['to'] !== $my_id) {
            throw new \Exception('数据不合法, 超出权限');
        }
        if ($result['func_id'] !== $func_id) {
            throw new \Exception('数据不合法, 超出权限');
        }

        switch ($func_id) {
            case 1:
                $ctl = new FriendController();
                $ctl->add($my_id, $friend_id);
                break;
            default:
                throw new \Exception('没有此功能消息');
        }

        // 已阅
        $this->redis->softDel($key);
    }

    public function getMessage($my_id, $is_read = 0)
    {
        $tmp = [];
        $msgs = $is_read ? $this->redis->getListRead($my_id) : $this->redis->getList($my_id);
        foreach ($msgs as $msg) {
            $tmp[] = $this->redis->get($msg);
        }
        return $tmp;
    }

    public function getCount($my_id, $is_read = 0)
    {
        return count($is_read ? $this->redis->getListRead($my_id) : $this->redis->getList($my_id));
    }

    public function readMessage($my_id, $key)
    {
        $result = $this->redis->get($key);

        if ($result['to'] !== $my_id) {
            throw new \Exception('数据不合法, 超出权限');
        }

        // 已阅
        $this->redis->softDel($key);
    }
}
