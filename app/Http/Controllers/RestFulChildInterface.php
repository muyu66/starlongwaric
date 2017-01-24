<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface RestFulChildInterface
{
    public function index($main_id);

    public function show($main_id, $child_id);

    public function store(Request $request);
}
