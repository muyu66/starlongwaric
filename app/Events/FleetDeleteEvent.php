<?php

namespace App\Events;

use App\Models\Fleet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class FleetDeleteEvent extends Event
{
    use SerializesModels;

    /**
     * @var int
     */
    public $fleet_id;

    public function __construct($fleet_id)
    {
        $this->fleet_id = $fleet_id;
    }
}
