<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use Muyu\Controllers\Template;
use Auth;

class AuthController extends Controller
{
    protected $except = ['postRegister', 'getCode', 'getCodeGenerate', 'getCodeValid', 'getCodeQuery'];

    public static $open_code = 1;

    public function postLogin()
    {
        if (self::$open_code && ! $this->loc()->getCodeQuery()) {
            throw new ApiException(40102);
        }

        if (! $this->checkFleet()) {
            throw new ApiException(40401);
        }

        $this->loc()->logLogin($this->getUserId(), g_get_ip());
    }

    public function getUser()
    {
        return Auth::user();
    }

    /**
     * 注册接口
     *
     * @param Request $request
     * @request email
     * @request password
     * @throws ApiException
     */
    public function postRegister(Request $request)
    {
        if (self::$open_code && ! $this->loc()->getCodeQuery()) {
            throw new ApiException(40102);
        }

        $array = $request->all();

        $this->loc()->check($array);

        $this->loc()->create($array);
    }

    public function getCode()
    {
        $ctl = new Template();
        return $ctl->view('code', [
            'name' => 'Muyu',
            'sign' => 'Inc',
            'message' => 'Captain, 欢迎登舰',
        ]);
    }

    public function getCodeGenerate()
    {
        return $this->loc()->getCaptcha()->generate();
    }

    public function getCodeValid()
    {
        return $this->loc()->getCaptcha()->valid();
    }
}
