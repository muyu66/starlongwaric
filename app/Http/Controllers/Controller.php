<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Exception;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $except;

    public function __construct()
    {
        $this->middleware('basic.auth', ['except' => $this->except]);
    }

    public function getUser()
    {
        $user = Auth::user();
        if (! $user) {
            throw new Exception('this user is not found');
        }

        return $user;
    }

    public function getUserId()
    {
        if (! $this->getUser()) {
            throw new Exception('this user is not found');
        }

        return $this->getUser()->id;
    }

    /**
     * @description
     * @return Fleet
     * @author Zhou Yu
     */
    public function getFleet()
    {
        return Fleet::where('user_id', $this->getUserId())
            ->where('alive', 1)
            ->first();
    }

    public function getFleetId()
    {
        if (! $this->getFleet()) {
            throw new Exception('this fleet is not found');
        }

        return $this->getFleet()->id;
    }
}
