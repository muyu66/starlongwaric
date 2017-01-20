<?php

namespace App\Http\Components\Events;

class Event
{
    protected $model;
    protected $choose;
    protected $params;
    protected $standard_params;

    public function __construct($model, $choose, $params)
    {
        $this->model = $model;
        $this->choose = $choose;
        $this->params = $params;
        $this->standard_params = $this->model->standard->params;
    }

    public function handle()
    {

    }
}
