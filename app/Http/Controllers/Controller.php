<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Fleet;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Cache;
use Illuminate\Validation\Validator;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $except;

    public $user;
    public $user_id;
    public $fleet;
    public $fleet_id;

    public function __construct()
    {
        $this->middleware('basic.auth', ['except' => $this->except]);
    }

    public function setUser($user = null)
    {
        $this->user = $user ? : Auth::user();
    }

    public function getUserId()
    {
        if (! $this->user_id) {
            $this->setUserId();
        }
        return $this->user_id;
    }

    public function setUserId($user_id = 0)
    {
        $this->user_id = $user_id ? : Auth::user()->id;
    }

    /**
     *
     *
     * @return Fleet
     * @author Zhou Yu
     */
    public function getFleet()
    {
        if (! $this->fleet) {
            $this->setFleet();
        }
        return $this->fleet;
    }

    public function setFleet($fleet = null)
    {
        $this->fleet = $fleet ? :
            Fleet::alive()->where('user_id', $this->getUserId())->firstOrFail();
    }

    public function getFleetId()
    {
        if (! $this->fleet_id) {
            $this->setFleetId();
            /**
             * 用此来确认，用户是否依然在线
             */
            $this->setOnlineStatus();
        }
        return $this->fleet_id;
    }

    public function setFleetId($fleet_id = 0)
    {
        $this->fleet_id = $fleet_id ? :
            Fleet::alive()->where('user_id', $this->getUserId())->firstOrFail()->id;
    }

    public function checkFleet()
    {
        $fleet = Fleet::alive()->where('user_id', $this->getUserId())->first();
        if (! $fleet) {
            return false;
        }
        return true;
    }

    public function getOnlineStatus($fleet_id)
    {
        // 空id 不保存
        if ($fleet_id) {
            $time = Cache::get('online/' . $fleet_id);
            g_get_online_status(time() - $time);
        }
    }

    public function setOnlineStatus()
    {
        Cache::forever('online/' . $this->getFleetId(), time());
    }

    public function validCore(Validator $validator)
    {
        if ($validator->fails()) {
            throw new ApiException(422, $validator->messages()->first());
        }
    }
}
