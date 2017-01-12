<?php

namespace App\Http\Controllers;

use App\Http\Components\Message;

class MessageController extends Controller
{
    /**
     * 获取未读消息
     *
     * @return int
     * @author Zhou Yu
     */
    public function getUnReadCount()
    {
        $msg = new Message();
        return $msg->getCount($this->getFleetId());
    }

    /**
     * 获取已读消息
     *
     * @return int
     * @author Zhou Yu
     */
    public function getReadCount()
    {
        $msg = new Message();
        return $msg->getCount($this->getFleetId(), 1);
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
}
