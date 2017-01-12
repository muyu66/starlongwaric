<?php

namespace App\Http\Controllers;

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
        $model->friends = g_array_add($model->friends, $friend_id);
        $model->save();
    }
}
