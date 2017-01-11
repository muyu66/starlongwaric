<?php

use App\Http\Controllers\StaffController;
use Illuminate\Database\Eloquent\Model;

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

    public function testGetMyCommander()
    {
        $this->get_with_login('staff/my-commander');
        $this->seeJsonContains(['id' => 5, "boss_id" => parent::UNIT_FLEET_ID]);
    }

    public function testCommander()
    {
        $ctl = new StaffController();
        $result = $ctl->commander(parent::UNIT_FLEET_ID);
        $this->assertTrue(is_array($result->toArray()));
    }

    public function testCreateStaff()
    {
        $ctl = new StaffController();
        $result = $ctl->createStaff(parent::UNIT_FLEET_ID);
        $this->assertInstanceOf(Model::class, $result);
    }

    public function testPostAppointCommander()
    {
        $this->post_with_login('staff/appoint-commander', ['commander_id' => 6]);
        $this->seeInDatabase('staff', ['id' => 6, 'is_commander' => "1"]);
        $this->seeInDatabase('staff', ['id' => 5, 'is_commander' => "0"]);
    }

    public function testCalcGold()
    {
        $ctl = new StaffController();
        $result = $ctl->calcGold(3);
        $this->assertTrue(is_numeric($result));
    }
}