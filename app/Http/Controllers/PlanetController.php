<?php

namespace App\Http\Controllers;

use App\Models\Planet;

class PlanetController extends Controller
{
    public function index()
    {

    }

    public function getName($id)
    {
        return Planet::getName($id);
    }

    public function getFullName($id)
    {
        return Planet::getFullName($id);
    }
}
