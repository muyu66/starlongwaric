<?php

use App\Http\Controllers\FriendController;

class FriendTest extends TestCase
{
    public function testPostIndex()
    {
        $this->post_with_login('friend', ['id' => 1]);
        $this->assertResponseOk();
    }

    public function testPostDelete()
    {
        $ctl = new FriendController();
        $ctl->add(2, 1);
        $this->post_with_login('friend/delete', ['id' => 1]);
        $this->seeInDatabase('friends', ['fleet_id' => 2, 'friends' => '[]']);
        $this->seeInDatabase('friends', ['fleet_id' => 1, 'friends' => '[]']);
        $this->assertResponseOk();
    }

    public function testAdd()
    {
        $ctl = new FriendController();
        $ctl->add(2, 1);
        $this->seeInDatabase('friends', ['fleet_id' => 2, 'id' => 1]);
        $this->seeInDatabase('friends', ['fleet_id' => 1, 'id' => 2]);
    }
}
