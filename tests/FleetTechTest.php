<?php

use App\Http\Controllers\FleetTechController;

class FleetTechTest extends TestCase
{
    public function testIndex()
    {
        $this->login();
        $this->get_with_login('fleet_teches');
        $this->seeJsonContains(['level' => 0]);
    }

    public function testShow()
    {
        $this->login();
        $this->get_with_login('fleet_teches/12');
        $this->seeJsonContains(['id' => 12]);
    }

    public function testUpdate()
    {
        /**
         * 构造虚拟数据
         */
        $fleet_tech = new stdClass();
        $fleet_tech->level = 0;

        $fleet = new stdClass();
        $fleet->gold = 1000;

        $fleet_tech_tech = new stdClass();
        $fleet_tech_tech->per_fee = 10;

        $amount = 0;
        $gold_is_empty = 0;
        $num = 5;
        $level_is_max = 0;

        $ctl = new FleetTechController();
        $ctl->update(
            $fleet_tech, $fleet, $fleet_tech_tech, $amount, $gold_is_empty, $level_is_max, $num
        );

        $this->assertTrue(is_numeric($fleet_tech->level));
        $this->assertTrue($amount * $fleet_tech_tech->per_fee + $fleet->gold === 1000);
        $this->assertTrue($gold_is_empty === 0);
    }

    public function testStore()
    {
        $this->post_with_login('fleet_teches', ['id' => 12, 'num' => 5]);
        $this->seeJsonContains(['id' => 12, 'update' => 5]);

        $this->post_with_login('fleet_teches', ['id' => 81]);
        $this->assertResponseStatus(404);
    }

    public function testPostAll()
    {
        $this->login();
        $this->post_with_login('fleet_teches/all');
        $this->seeJson();
        $this->assertResponseOk();
    }
}