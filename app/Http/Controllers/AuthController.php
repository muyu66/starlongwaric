<?php

namespace App\Http\Controllers;

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

    private $captcha;

    public function __construct()
    {
        parent::__construct();

        $this->captcha = new Captcha();
        $this->captcha->useMemcache(Cache::getMemcached());
    }

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

    public function getLogin()
    {
        if (! $this->getCodeQuery() || $this->getCodeQuery() == 'error') {
            throw new Exception('验证码不正确');
        }

        return ['status' => '1'];
    }

    public function getUser()
    {
        return Auth::user();
    }

    public function postRegister(Request $request)
    {
        if (! $this->getCodeQuery() || $this->getCodeQuery() == 'error') {
            throw new Exception('验证码不正确');
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

    public function getCodeGenerate()
    {
        return $this->captcha->generate();
    }

    public function getCodeValid()
    {
        return $this->captcha->valid();
    }

    public function getCodeQuery()
    {
        return $this->captcha->query();
    }
}
