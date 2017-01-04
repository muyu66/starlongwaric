<?php

class AuthTest extends TestCase
{
    public function testPostLogin()
    {
        $this->post('auth/login', [
            'email' => parent::UNIT_EMAIL,
            'password' => parent::UNIT_PASSWORD,
        ]);
        $this->seeJson(['status' => '1']);
        $this->assertResponseOk();
    }

    public function testGetUser()
    {
        $this->login();
        $this->get('auth/user');
        $this->seeJson(['email' => parent::UNIT_EMAIL]);
        $this->assertResponseOk();
    }

    public function testGetLogout()
    {
        $this->login();
        $this->get('auth/logout');
        $this->seeJson(['status' => '1']);
        $this->assertResponseOk();
    }
}
