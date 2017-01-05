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

    private function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors());
        }
    }

    public function getUser()
    {
        return Auth::user();
    }

    public function postRegister(Request $request)
    {
        $this->check($request);

        return $this->create($request->all());
    }

    public function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
