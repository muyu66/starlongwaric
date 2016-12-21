<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $models = User::get();
        foreach ($models as $model) {
            $model->avatar = $this->getAvater($model->email);
        }
        return $models;
    }

    public function show($id)
    {
        $model = User::where('id', $id)->firstOrFail();
        $model->avatar = $this->getAvater($model->email);
        return $model;
    }

    private function getAvater($email)
    {
        if ($this->getQiniuAvater($email)) {
            return $this->getQiniuAvater($email);
        }
        return $this->getGravatar($email);
    }

    private function getGravatar($email)
    {
        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email)));
    }

    private function getQiniuAvater($email)
    {
        return '';
    }
}