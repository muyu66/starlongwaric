<?php

use App\Http\Controllers\FightLogController;

class FightLogTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->testRecord();
    }

    public function testRecord()
    {
        /**
         * 我方胜利
         */
        $my = new stdClass();
        $enemy = new stdClass();
        $my->id = 2;
        $my->power = 10000;
        $enemy->id = 31;
        $enemy->power = 8000;
        $result = 1;
        $booty = ['gold' => 100, 'fule' => 40];
        $ctl = new FightLogController();
        $ctl->record($my, $enemy, $result, $booty);
        $this->seeInDatabase('fight_logs', ['id' => 1, 'my_id' => 2]);

        /**
         * 我方被战斗
         */
        $my = new stdClass();
        $enemy = new stdClass();
        $my->id = 31;
        $my->power = 8000;
        $enemy->id = 2;
        $enemy->power = 10000;
        $result = 0;
        $booty = ['gold' => 100, 'fule' => 40];
        $ctl = new FightLogController();
        $ctl->record($my, $enemy, $result, $booty);
        $this->seeInDatabase('fight_logs', ['id' => 2, 'enemy_id' => 2]);
    }

    public function testIndex()
    {
        $this->get_with_login('fight_logs');
        $this->seeJsonContains(["my_id" => 2]);
        $this->seeJsonContains(["enemy_id" => 2]);
    }

    public function testShow()
    {
        $this->get_with_login('fight_logs/my');
        $this->seeJsonContains(["my_id" => 2]);
        $this->dontSeeJson(["enemy_id" => 2]);

        $this->get_with_login('fight_logs/enemy');
        $this->seeJsonContains(["enemy_id" => 2]);
        $this->dontSeeJson(["my_id" => 2]);
    }
}
