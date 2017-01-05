<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Exception;

class AuthController extends Controller
{
    protected $except = ['postRegister'];

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

    public function getUser()
    {
        return Auth::user();
    }

    public function postRegister(Request $request)
    {
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
}
