<?php

use App\Http\Controllers\EnemyController;

class EnemyTest extends TestCase
{
    public function testIndex()
    {
        $this->get_with_login('enemies');
        $this->seeJsonContains(['id' => 1]);
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->get_with_login('enemies/11');
        $this->seeJsonContains(['id' => 11]);
        $this->assertResponseOk();
    }

    public function testRandoms()
    {
        $ctl = new EnemyController();
        $result = $ctl->randoms(6000)->toArray();
        $this->assertTrue(is_array($result[0]));
    }

    public function testRandom()
    {
        $ctl = new EnemyController();
        $result = $ctl->random(6000)->toArray();
        $this->assertTrue(is_array($result));
        $this->assertTrue(is_null($result[0]));
    }
}
