<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Request;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $except;

    protected $user;
    protected $user_id;
    protected $fleet;
    protected $fleet_id;

    public function __construct()
    {
        if (g_isDebug() && Request::header('x_user_id')) {
            $this->user = User::findXidOrFail(Request::header('x_user_id'));
        } else {
            $this->middleware('basic.auth', ['except' => $this->except]);
            $this->user = Auth::user();
        }

        if ($this->user) {
            $this->user_id = $this->user->id;
            $this->fleet = Fleet::where('user_id', $this->user_id)
                ->where('active', 1)
                ->first();
            $this->fleet_id = $this->fleet ? $this->fleet->id : '';
        }
    }
}
