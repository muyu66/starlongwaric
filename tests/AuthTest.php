<?php

class AuthTest extends TestCase
{
    public function testPostRegister()
    {
        $this->post('auth/register', [
            'email' => 'aaa@aaa.com',
            'password' => '111111',
        ]);
        $this->seeInDatabase('users', ['email' => 'aaa@aaa.com']);
        $this->assertResponseOk();
    }

    public function testGetUser()
    {
        $this->get_with_login('auth/user');
        $this->seeJsonContains(['email' => self::UNIT_EMAIL]);
        $this->assertResponseOk();
    }
}
