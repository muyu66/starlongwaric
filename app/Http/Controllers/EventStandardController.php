<?php

namespace App\Http\Controllers;

use App\Models\EventStandard;

class EventStandardController extends Controller
{
    public function index()
    {
        return EventStandard::get();
    }

    public function show($id)
    {
        return EventStandard::where('id', $id)->firstOrFail();
    }
}