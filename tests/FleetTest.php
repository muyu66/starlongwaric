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
        $ctl = new FleetController();
        $ctl->createFleetBody($this->fleet->id);
        $this->seeInDatabase('fleet_bodies', ['fleet_id' => '3']);
    }

    public function testCreateFleetTech()
    {
        $ctl = new FleetController();
        $ctl->createFleetTech($this->fleet->id);
        $this->seeInDatabase('fleet_teches', ['fleet_id' => '3']);
    }

    public function testCreateFleetPower()
    {
        $ctl = new FleetController();
        $model = $ctl->updateFleetPower($this->fleet);
        $this->assertTrue($model->id == '3' && $model->power > 0);
    }

    public function testCreateFleetStaff()
    {
        $ctl = new FleetController();
        $ctl->createFleetStaff($this->fleet->id);
        $this->seeInDatabase('staff', ['id' => 5, 'is_commander' => '1']);
        $this->seeInDatabase('staff', ['id' => 6, 'is_commander' => '0']);
    }

    public function testStore()
    {
        $this->post_with_login('fleets', ['name' => 'Cindy']);
        $this->seeInDatabase('fleets', ['id' => 4, 'name' => 'Cindy']);
    }
}