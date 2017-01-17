<?php

namespace App\Http\Controllers;

use App\Http\Components\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * 获取未读消息
     *
     * @return array
     * @author Zhou Yu
     */
    public function getUnReadCount()
    {
        $msg = new Message();
        return ['count' => $msg->getCount($this->getFleetId())];
    }

    /**
     * 获取已读消息
     *
     * @return array
     * @author Zhou Yu
     */
    public function getReadCount()
    {
        $msg = new Message();
        return ['count' => $msg->getCount($this->getFleetId(), 1)];
    }

    public function getUnRead()
    {
        $msg = new Message();
        return $msg->getMessage($this->getFleetId());
    }

    public function getRead()
    {
        $msg = new Message();
        return $msg->getMessage($this->getFleetId(), 1);
    }

    public function postAgree(Request $request)
    {
        $func_id = $request->input('func_id');
        $my_id = $this->getFleetId();
        $friend_id = $request->input('from');
        $key = $request->input('key');

        $ctl = new Message();
        $ctl->resolveMessageFunc($func_id, $my_id, $friend_id, $key);
    }

    public function postRead(Request $request)
    {
        $my_id = $this->getFleetId();
        $key = $request->input('key');

        $ctl = new Message();
        $ctl->readMessage($my_id, $key);
    }
}
