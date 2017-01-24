<?php

namespace App\Http\Logics;

use App\Models\Friend;

class FriendLogic extends Logic
{
    /**
     * 好友互加
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
