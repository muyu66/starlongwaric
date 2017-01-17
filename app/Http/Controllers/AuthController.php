<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\CustomException;
use App\Http\Commons\Redis;
use App\Models\User;
use Illuminate\Http\Request;
use Muyu\Controllers\Captcha;
use Muyu\Controllers\Template;
use Validator;
use Auth;
use Exception;
use Cache;

class AuthController extends Controller
{
    protected $except = ['postRegister', 'getCode', 'getCodeGenerate', 'getCodeValid', 'getCodeQuery'];

    public static $open_code = 1;

    private function check(Array $array)
    {
        $validator = Validator::make($array, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages(), 422);
        }
    }

    public function postLogin()
    {
        if (self::$open_code && ! $this->getCodeQuery()) {
            throw new ApiException(40102);
        }
        return '';
    }

    public function getUser()
    {
        return Auth::user();
    }

    public function postRegister(Request $request)
    {
        if (self::$open_code && ! $this->getCodeQuery()) {
            throw new CustomException(401, '验证码错误');
        }

        $array = $request->all();

        $this->check($array);

        return $this->create($array);
    }

    public function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getCode()
    {
        $ctl = new Template();
        return $ctl->view('code', [
            'generate' => 'http://www.slw.app/auth/code-generate',
            'valid' => 'http://www.slw.app/auth/code-valid',
            'query' => 'http://www.slw.app/auth/code-query',
        ]);
    }

    public function getCaptcha()
    {
        $redis = new Redis();
        $captcha = new Captcha();
        $captcha->useRedis($redis->getConnection());
        return $captcha;
    }

    public function getCodeGenerate()
    {
        return $this->getCaptcha()->generate();
    }

    public function getCodeValid()
    {
        return $this->getCaptcha()->valid();
    }

    public function getCodeQuery()
    {
        return $this->getCaptcha()->query();
    }
}
