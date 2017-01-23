<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    protected $except = ['getTest'];

    public function getTest()
    {
//        $this->getLoc()->aaaa();
    }
}
