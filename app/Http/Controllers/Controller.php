<?php

namespace App\Http\Controllers;

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

    protected $user;
    protected $user_id;
    protected $except;

    public function __construct()
    {
        if (g_isDebug() && Request::header('x_user_id')) {
            $this->user = User::findOrFail(Request::header('x_user_id'));
        } else {
            $this->middleware('auth', ['except' => $this->except]);
            $this->user = Auth::user();
        }

        if ($this->user) {
            $this->user_id = $this->user->id;
        }
    }
}
