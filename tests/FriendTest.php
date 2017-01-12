<?php

use App\Http\Controllers\FriendController;

class FriendTest extends TestCase
{
    public function testPostIndex()
    {
        $this->post_with_login('friend', ['id' => 1]);
        $this->assertResponseOk();
    }

    public function testAgree()
    {
        $ctl = new FriendController();
        $ctl->agree(2, 1);
        $this->seeInDatabase('friends', ['fleet_id' => 2, 'id' => 1]);
        $this->seeInDatabase('friends', ['fleet_id' => 1, 'id' => 2]);
    }
}
