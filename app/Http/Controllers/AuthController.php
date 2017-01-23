<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Commons\Redis;
use App\Models\User;
use Illuminate\Http\Request;
use Muyu\Controllers\Captcha;
use Muyu\Controllers\Template;
use Orm\Controllers\Connections\Connection;
use Validator;
use Auth;

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

        $this->validCore($validator);
    }

    public function postLogin()
    {
        if (self::$open_code && ! $this->getCodeQuery()) {
            throw new ApiException(40102);
        }

        if (! $this->checkFleet()) {
            throw new ApiException(40401);
        }

        $this->getLoc()->logLogin($this->getUserId(), g_get_ip());



//        $host = '127.0.0.1';
//        $port = '6379';
//        $database = '4';
//        $password = 'muyuzhouyu1M';
//        $redis = new Client(compact('host', 'port', 'database', 'password'));
//
//        $redis->flushdb();
//
//        Connection::create($redis);
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
        if (self::$open_code && ! $this->getCodeQuery()) {
            throw new ApiException(40102);
        }

        $array = $request->all();

        $this->check($array);

        $this->create($array);
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
            'name' => 'Muyu',
            'sign' => 'Inc',
            'message' => 'Captain, 欢迎登舰',
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
