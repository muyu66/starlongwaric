<?php

namespace App\Http\Controllers;

use App\Models\FightLog;
use Illuminate\Http\Request;

class FightLogController extends Controller implements RestFulChildInterface
{
    public function index($fleet_id)
    {
        $this->showMe($fleet_id);

        return FightLog::where('my_id', $fleet_id)
            ->orWhere('enemy_id', $fleet_id)
            ->with('enemy')
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function show($fleet_id, $id)
    {
        $this->showMe($fleet_id);

        if ($id === 'active') {
            return FightLog::where('my_id', $fleet_id)
                ->with('enemy')
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        if ($id === 'passive') {
            return FightLog::where('enemy_id', $fleet_id)
                ->with('enemy')
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        return FightLog::where('my_id', $fleet_id)
            ->with('enemy')
            ->orderBy('updated_at', 'desc')
            ->findOrFail($id);
    }

    public function store(Request $request)
    {

    }
}
