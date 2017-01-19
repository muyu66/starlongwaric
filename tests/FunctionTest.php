<?php

class FunctionTest extends TestCase
{
    public function testGArrayDel()
    {
        $tmp = [1, 2, 3, 4, 5];
        $tmp = g_array_del($tmp, 3);
        $tmp = g_array_del($tmp, 3);
        $this->assertTrue(! array_search(3, $tmp));
        $this->assertTrue(is_array($tmp));
    }

    public function testGetLatelyTime()
    {
        $this->assertEquals(['is_online' => 0, 'time' => '1小时'], g_get_online_status(3600));
        $this->assertEquals(['is_online' => 0, 'time' => '1天'], g_get_online_status(3600 * 24));
        $this->assertEquals(['is_online' => 0, 'time' => '40分钟'], g_get_online_status(60 * 40));
        $this->assertEquals(['is_online' => 1, 'time' => '0'], g_get_online_status(30));
        $this->assertEquals(['is_online' => 0, 'time' => '26天'], g_get_online_status(3600 * 24 * 26));
        $this->assertEquals(['is_online' => 0, 'time' => '超过1个月'], g_get_online_status(3600 * 24 * 35));
    }
}
