<?php

use App\Http\Controllers\FightController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\EnemyController;

class FightTest extends TestCase
{
//    public function testPostEnemy()
//    {
//        $this->post_with_login('fight/enemy');
//        $this->seeJson();
//        $this->assertResponseOk();
//    }

//    public function testLog()
//    {
//        $this->login();
//
//        $my = new FleetController();
//        $enemy = new EnemyController();
//        $my = $my->show();
//        $enemy = $enemy->getRandom();
//
//        $ctl = new FightController();
//        $ctl->log($my, $enemy, 1);
//    }

    public function testBooty()
    {
        $this->login();

        $my = new FleetController();
        $enemy = new EnemyController();
        $my = $my->show();
        $enemy = $enemy->getRandom();

        $ctl = new FightController();
        dump($ctl->booty(1, $my, $enemy));
    }
}
