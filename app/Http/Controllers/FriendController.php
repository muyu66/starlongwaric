<?php

namespace App\Http\Controllers;

use App\Http\Components\Message;
use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function getIndex()
    {
        return Friend::belong($this->getFleetId())->first();
    }

    public function index($fleet_id)
    {
        return Friend::belong($fleet_id)->first();
    }

    // todo
    public function postIndex(Request $request)
    {
        $friend_id = $request->input('id');
        $model = Friend::firstOrNew([
            'fleet_id' => $this->getFleetId(),
        ]);
        if ($model->friends === g_array_add($model->friends, $friend_id)) {
            throw new \Exception('好友已经存在于您的列表中');
        } else {
            $msg = new Message();
            $msg->pushMessage($this->getFleetId(), $friend_id, '交朋友');
        }


//        $friend_id = $request->input('id');
//        $model = Friend::firstOrNew([
//            'fleet_id' => $this->getFleetId(),
//        ]);
//        $model->friends = g_array_add($model->friends, $friend_id);
//        $model->save();
    }
}
