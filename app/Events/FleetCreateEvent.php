<?php

namespace App\Events;

use App\Models\Fleet;
use Illuminate\Queue\SerializesModels;

class FleetCreateEvent extends Event
{
    use SerializesModels;

    /**
     * @var Fleet
     */
    public $fleet;

    /**
     * @var string 舰长名称
     */
    public $name;

    /**
     * @var int
     */
    public $user_id;

    public function __construct(Fleet $fleet, $name, $user_id)
    {
        $this->fleet = $fleet;
        $this->name = $name;
        $this->user_id = $user_id;
    }
}
