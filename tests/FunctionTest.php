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
}
