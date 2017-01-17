<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
//use Cache;

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

    public function getUser()
    {
        if (! $this->user) {
            $this->setUser();
        }
        return $this->user;
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
        }
//        $this->setOnlineStatus($this->fleet_id);
        return $this->fleet_id;
    }

    public function setFleetId($fleet_id = 0)
    {
        $this->fleet_id = $fleet_id ? :
            Fleet::alive()->where('user_id', $this->getUserId())->firstOrFail()->id;
    }

//    public function getOnlineStatus($fleet_id)
//    {
//        return 'sadsdaads';
//        $time = Cache::get('online/' . $fleet_id);
//        return $time.'sada';
//    }
//
//    public function setOnlineStatus($fleet_id)
//    {
//        // 5分钟内有访问，则算在线
//        Cache::put('online/' . $fleet_id, time(), 5);
//    }
}
