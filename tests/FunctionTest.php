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
        $this->assertEquals('1小时', g_get_lately_time(3600));
        $this->assertEquals('1天', g_get_lately_time(3600 * 24));
        $this->assertEquals('40分钟', g_get_lately_time(60 * 40));
        $this->assertEquals('30秒', g_get_lately_time(30));
        $this->assertEquals('26天', g_get_lately_time(3600 * 24 * 26));
        $this->assertEquals('超过1个月', g_get_lately_time(3600 * 24 * 35));
    }
}
