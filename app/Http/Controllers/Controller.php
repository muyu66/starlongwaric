<?php

namespace App\Http\Controllers;

use App\Http\Logics\AuthLogic;
use App\Http\Logics\EnemyLogic;
use App\Http\Logics\EventLogic;
use App\Http\Logics\FightLogic;
use App\Http\Logics\FightLogLogic;
use App\Http\Logics\FleetBodyLogic;
use App\Http\Logics\FleetConfigLogic;
use App\Http\Logics\FleetEventLogic;
use App\Http\Logics\FleetLogic;
use App\Http\Logics\FleetPowerLogic;
use App\Http\Logics\FleetTechLogic;
use App\Http\Logics\FriendLogic;
use App\Http\Logics\Logic;
use App\Http\Logics\MilitaryRankLogic;
use App\Http\Logics\PlanetLogic;
use App\Models\Base;
use App\Models\Fleet;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Cache;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $except;

    private $user;
    private $user_id;
    private $fleet;
    private $fleet_id;

    /**
     * @var Logic
     */
    private $loc;

    public function __construct()
    {
        $this->middleware('basic.auth', ['except' => $this->except]);

        /**
         * 分发 Logical
         */
        $loc = str_replace('Controller', 'Logic', static::class);
        if (class_exists($loc)) {
            $this->loc = new $loc;
        }
    }

    /**
     * 返回分发的 Logical
     *
     * @return FightLogic|FleetEventLogic|PlanetLogic|MilitaryRankLogic|FriendLogic|FleetTechLogic|FleetPowerLogic|FleetConfigLogic|FleetBodyLogic|FightLogLogic|EventLogic|EnemyLogic|FleetLogic|AuthLogic|Logic
     * @author Zhou Yu
     */
    public function loc()
    {
        return $this->loc;
    }

    /**
     * 获取类名 例如 AuthController
     *
     * @return mixed
     * @author Zhou Yu
     */
    public static function class()
    {
        return g_get_class_name(static::class);
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

    protected function showMe(&$id)
    {
        if ($id === 'me') {
            $id = $this->getFleetId();
        }
    }

    /**
     *
     *
     * @param $ids
     * @param Base $model_class
     * @author Zhou Yu
     */
    protected function storeAll(&$ids, $model_class)
    {
        if ($ids === 'all') {
            $ids = $model_class::belong($this->getFleetId())->get()->pluck('id');
        }
    }
}
