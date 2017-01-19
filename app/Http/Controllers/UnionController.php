<?php

namespace App\Http\Controllers;

use App\Models\Union;

class UnionController extends Controller
{
    public function show($id)
    {
        return Union::findOrFail($id);
    }
}
