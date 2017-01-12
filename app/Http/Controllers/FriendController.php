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
            $msg->pushMessageFunc($this->getFleetId(), $friend_id, 1);
        }
    }

    /**
     * 对方同意好友添加
     *
     * @param $my_id
     * @param $friend_id
     * @author Zhou Yu
     */
    public function agree($my_id, $friend_id)
    {
        $model = Friend::firstOrNew([
            'fleet_id' => $my_id,
        ]);
        $model->friends = g_array_add($model->friends, $friend_id);
        $model->save();

        $model = Friend::firstOrNew([
            'fleet_id' => $friend_id,
        ]);
        $model->friends = g_array_add($model->friends, $my_id);
        $model->save();
    }
}
