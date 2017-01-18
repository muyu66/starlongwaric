<?php

namespace App\Http\Controllers;

use App\Models\Galaxy;

class GalaxyController extends Controller
{
    public function index()
    {

    }

    public function getAll()
    {
        return Galaxy::with(['quadrant.planet'])->get();
    }
}
