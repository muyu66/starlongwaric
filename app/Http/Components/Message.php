<?php

namespace App\Http\Components;

use App\Http\Commons\Redis;

class Message
{
    public function pushMessage($from_id, $to_id, $content)
    {
        $redis = new Redis();
        $redis->set($to_id, [
            'content' => $content,
            'from' => $from_id,
        ], 1296000); // 消息保存15天
    }

    public function getMessage($my_id, $is_read = 0)
    {
        $tmp = [];
        $redis = new Redis();
        $msgs = $is_read ? $redis->getListRead($my_id) : $redis->getList($my_id);
        foreach ($msgs as $msg) {
            $tmp[] = $redis->get($msg);
        }
        return $tmp;
    }

    public function getCount($my_id, $is_read = 0)
    {
        $redis = new Redis();
        return count($is_read ? $redis->getListRead($my_id) : $redis->getList($my_id));
    }

    public function pullMessage($my_id)
    {
        $tmp = [];
        $redis = new Redis();
        $msgs = $redis->getList($my_id);
        foreach ($msgs as $msg) {
            $tmp[] = $redis->pull($msg);
        }
        return $tmp;
    }
}
