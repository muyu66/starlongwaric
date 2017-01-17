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
     * Delete friend ship
     *
     * @param Request $request
     * @throws \Exception
     * @author Zhou Yu
     */
    public function postDelete(Request $request)
    {
        $friend_id = $request->input('id');
        $this->del($this->getFleetId(), $friend_id);
    }

    /**
     * hao you hu jia
     *
     * @param $my_id
     * @param $friend_id
     * @author Zhou Yu
     */
    public function add($my_id, $friend_id)
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

    public function del($my_id, $friend_id)
    {
        $model = Friend::firstOrNew([
            'fleet_id' => $my_id,
        ]);
        $model->friends = g_array_del($model->friends, $friend_id);
        $model->save();

        $model = Friend::firstOrNew([
            'fleet_id' => $friend_id,
        ]);
        $model->friends = g_array_del($model->friends, $my_id);
        $model->save();
    }
}
