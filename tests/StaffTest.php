<?php

class StaffTest extends TestCase
{
    public function testGetMy()
    {
        $this->get_with_login('staff/my');
        $this->seeJson([]);
    }

    public function testGetMarket()
    {
        $this->get_with_login('staff/market');
        $this->seeJsonContains(['id' => 1, "boss_id" => "0"]);
    }
}