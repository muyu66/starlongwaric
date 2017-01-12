<?php

use App\Http\Controllers\UserController;

class UserTest extends TestCase
{
    public function testIndex()
    {
        $this->get_with_login('users');
        $this->seeJsonContains(['id' => 1]);
        $this->seeJsonContains(['id' => 2]);
    }

    public function testShow()
    {
        $this->get_with_login('users/2');
        $this->seeJsonContains(['id' => 2]);
    }

    public function testGetAvater()
    {
        $uri = $this->getPrivate(UserController::class, 'getAvater', static::UNIT_EMAIL);
        $this->assertTrue($this->existUri($uri));
    }
}
