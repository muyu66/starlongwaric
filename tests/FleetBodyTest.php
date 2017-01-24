<?php

use App\Http\Controllers\FleetBodyController;

class FleetBodyTest extends TestCase
{
    public function testIndex()
    {
        $this->get_with_login('fleet_bodies');
        $this->seeJsonContains(['health' => 100]);
    }

    public function testShow()
    {
        $this->get_with_login('fleet_bodies/8');
        $this->seeJsonContains(['id' => 8]);
    }

    public function testFix()
    {
        /**
         * 构造虚拟数据
         */
        $fleet_body = new stdClass();
        $fleet_body->health = 80;

        $fleet = new stdClass();
        $fleet->gold = 1000;

        $fleet_body_widget = new stdClass();
        $fleet_body_widget->per_fee = 10;

        $amount = 0;
        $gold_is_empty = 0;

        $ctl = new FleetBodyController();
        $ctl->loc()->fix($fleet_body, $fleet, $fleet_body_widget, $amount, $gold_is_empty);

        $this->assertTrue($fleet_body->health <= 100);
        $this->assertTrue($amount * $fleet_body_widget->per_fee + $fleet->gold === 1000);
        $this->assertTrue($gold_is_empty === 0);
    }

    public function testStore()
    {
        $this->post_with_login('fleet_bodies', ['id' => 8]);
        $this->seeJsonContains(['id' => 8, 'fix' => 0]);

        $this->post_with_login('fleet_bodies', ['id' => 81]);
        $this->assertResponseStatus(404);
    }

    public function testPostAll()
    {
        $this->post_with_login('fleet_bodies/all');
        $this->seeJson();
        $this->assertResponseOk();
    }
}