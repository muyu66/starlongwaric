<?php

use App\Http\Controllers\FightController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\EnemyController;

class FightTest extends TestCase
{
    private $my;
    private $enemy;

    public function setUp()
    {
        parent::setUp();
        $my = new FleetController();
        $enemy = new EnemyController();
        $this->my = $my->show();
        $this->enemy = $enemy->getRandom();
    }

    public function testCalc()
    {
        $this->login();

        $ctl = new FightController();
        $result = $ctl->calc($this->my, $this->enemy);
        $this->assertTrue(in_array($result, [-1, 0, 1]));
    }

    public function testBooty()
    {
        $this->login();

        $ctl = new FightController();
        $result = $ctl->booty(1, $this->my, $this->enemy);

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('gold', $result);
    }

    public function testPostEnemy()
    {
        $this->post_with_login('fight/enemy');
        $this->assertResponseOk();
        $this->seeInDatabase('fight_logs', ['id' => 1]);
    }
}
