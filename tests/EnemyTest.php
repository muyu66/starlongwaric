<?php

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

    public function testGetRandoms()
    {
        $this->get_with_login('enemies/randoms');
        $this->seeJson();
        $this->assertResponseOk();
    }

    public function testGetRandom()
    {
        $this->get_with_login('enemies/random');
        $this->seeJson();
        $this->assertResponseOk();
    }
}
