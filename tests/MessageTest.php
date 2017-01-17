<?php

use App\Http\Controllers\MessageController;

class MessageTest extends TestCase
{
    public function testGetUnReadCount()
    {
        $msg = new MessageController();;
        $this->assertTrue($msg->getUnReadCount() === ['count' => 0]);
    }

    public function testGetReadCount()
    {
        $msg = new MessageController();;
        $this->assertTrue($msg->getReadCount() === ['count' => 0]);
    }

    public function testGetUnRead()
    {
        $msg = new MessageController();;
        $this->assertTrue(is_array($msg->getUnRead()));
    }

    public function testGetRead()
    {
        $msg = new MessageController();;
        $this->assertTrue(is_array($msg->getRead()));
    }

    /**
     * public function postAgree(Request $request)
     * todo 以后在 Message 测试
     */

    /**
     * public function postRead(Request $request)
     * todo 以后在 Message 测试
     */
}
