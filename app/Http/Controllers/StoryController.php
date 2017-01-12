<?php

namespace App\Http\Controllers;

use App\Models\Story;

class StoryController extends Controller
{
    public function index()
    {
        return Story::get();
    }

    public function show($id)
    {
        return Story::where('id', $id)->firstOrFail();
    }
}
