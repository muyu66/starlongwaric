<?php

use App\Http\Controllers\FleetController;
use App\Http\Logics\FleetBodyLogic;
use App\Http\Logics\FleetTechLogic;
use App\Http\Logics\StaffLogic;

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
        $this->get_with_login('fleets/31'); // 任意数字都可访问到
        $this->seeJsonContains([
            'name' => '胡汉三',
            'power' => 7900,
            'staff' => 2,
            'planet' => '地球',
        ]);
    }

    public function testValid()
    {
        $ctl = new FleetController();
        $result = $ctl->loc()->check(['name' => '张哈哈']);
        $this->assertEquals(null, $result);

        /**
         * 错误的输入则
         */
        $this->assertException(function () use ($ctl) {
            return $ctl->loc()->check(['name' => '']);
        }, 422);
    }

    public function testCreateFleet()
    {
        return $this->getPrivate(FleetController::class, 'createFleet', '德马西亚');
    }

    public function testCreateFleetBody()
    {
        $fleet_body = new FleetBodyLogic();
        $fleet_body->createCopy($this->fleet->id);
        $this->seeInDatabase('fleet_bodies', ['fleet_id' => '3']);
    }

    public function testCreateFleetTech()
    {
        $fleet_tech = new FleetTechLogic();
        $fleet_tech->createCopy($this->fleet->id);
        $this->seeInDatabase('fleet_teches', ['fleet_id' => '3']);
    }

    public function testCreateFleetPower()
    {
        $ctl = new FleetController();
        $model = $ctl->loc()->updateFleetPower($this->fleet);
        $this->assertTrue($model->id == '3' && $model->power > 0);
    }

    public function testCreateFleetStaff()
    {
        $loc = new StaffLogic();
        $loc->create($this->fleet->id, 1);
        $loc->create($this->fleet->id);
        $this->seeInDatabase('staff', ['id' => 5, 'is_commander' => '1']);
        $this->seeInDatabase('staff', ['id' => 6, 'is_commander' => '0']);
    }

    public function testStore()
    {
        $this->post_with_login('fleets', ['name' => 'Cindy']);
        $this->seeJsonContains(['code' => 40501]);
    }
}