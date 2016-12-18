<?php

class Database extends TestCase
{
    public function testUser()
    {
        $this->seeInDatabase('users', ['email' => parent::UNIT_EMAIL]);
    }
}


