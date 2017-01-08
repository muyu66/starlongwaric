<?php

use App\Http\Controllers\FleetController;

class FleetTest extends TestCase
{
    private $fleet;

    public function setUp()
    {
        parent::setUp();
        $this->fleet = $this->testCreateFleet();
    }

    public function testIndex()
    {
        $this->get_with_login('fleets');
        $this->seeJsonContains(['name' => '胡汉三']);
    }

    public function testShow()
    {
        $this->get_with_login('fleets/31');
        $this->seeJsonContains(['name' => '胡汉三']);
    }

    public function testValid()
    {
        $ctl = new FleetController();
        $result = $ctl->valid(['name' => '张哈哈']);
        $this->assertEquals(null, $result);

        /**
         * 错误的输入则
         */
        $this->assertException(function () use ($ctl) {
            return $ctl->valid(['name' => '']);
        }, 422);
    }

    public function testCreateFleet()
    {
        return $this->getPrivate(FleetController::class, 'createFleet', '德马西亚');
    }

    public function testCreateFleetBody()
    {
        $this->getPrivate(FleetController::class, 'createFleetBody', $this->fleet);
        $this->seeInDatabase('fleet_bodies', ['fleet_id' => '3']);
    }

    public function testCreateFleetTech()
    {
        $this->getPrivate(FleetController::class, 'createFleetTech', $this->fleet);
        $this->seeInDatabase('fleet_teches', ['fleet_id' => '3']);
    }

    public function testCreateFleetPower()
    {
        $this->getPrivate(FleetController::class, 'createFleetPower', $this->fleet);
        $this->seeInDatabase('fleets', ['id' => 3, 'name' => '德马西亚']);
    }

    public function testStore()
    {
        $this->post_with_login('fleets', ['name' => 'Cindy']);
        $this->seeInDatabase('fleets', ['id' => 4, 'name' => 'Cindy']);
    }
}