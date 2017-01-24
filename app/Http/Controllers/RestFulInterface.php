<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface RestFulInterface
{
    public function index();

    public function show($id);

    public function store(Request $request);
}
