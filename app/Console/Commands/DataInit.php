<?php

namespace App\Console\Commands;

use App\Models\Config;
use App\Models\Event;
use App\Models\FleetBodyWidget;
use App\Models\FleetTechTech;
use App\Models\Staff;
use App\Models\Story;
use Illuminate\Console\Command;

class DataInit extends Command
{
    protected $signature = 'data:init {widget?}';
    protected $description = 'init some data';

    public function handle()
    {
        $widget = $this->argument('widget') ? : 'all';
        $this->$widget();
    }

    private function all()
    {
        $this->initConfig();
        $this->initStory();
        $this->initHero();
        $this->initEvent();

        $this->fleetBodyWidget();
        $this->fleetTechTech();
    }

    private function initStory()
    {
        foreach (g_load_import('story', 'main') as $story) {
            $model = Story::firstOrNew([
                'chapter' => $story['chapter'],
            ]);
            $model->content = $story['content'];
            $model->timeline = $story['timeline'];
            $model->save();
        }
    }

    private function initConfig()
    {
        foreach (g_load_import('data', 'globalConfig') as $key => $value) {
            $model = Config::firstOrNew([
                'key' => $key,
            ]);
            $model->value = $value;
            $model->save();
        }
    }

    private function initHero()
    {
        foreach (g_load_import('hero', 'heroes') as $hero) {
            $model = Staff::firstOrNew([
                'name' => $hero['name'],
                'desc' => $hero['desc'],
            ]);
            $model->boss_id = 0;
            $model->is_hero = 1;
            $model->character = $hero['character'];
            $model->job = $hero['job'];
            $model->job_ability = $hero['job_ability'];
            $model->intelligence = $hero['intelligence'];
            $model->loyalty = $hero['loyalty'];
            $model->save();
        }
    }

    private function initEvent()
    {
        foreach (g_load_import('event', 'normal') as $event) {
            $model = Event::firstOrNew([
                'name' => $event['name'],
                'desc' => $event['desc'],
            ]);
            $model->event = $event['event'];
            $model->params = $event['params'];
            $model->save();
        }
    }

    private function fleetBodyWidget()
    {
        foreach (g_load_import('data', __FUNCTION__) as $item) {
            $model = FleetBodyWidget::firstOrNew([
                'name' => $item['name'],
            ]);
            $model->desc = $item['desc'];
            $model->per_fee = $item['per_fee'];
            $model->per_power = $item['per_power'];
            $model->save();
        }
    }

    private function fleetTechTech()
    {
        foreach (g_load_import('data', __FUNCTION__) as $item) {
            $model = FleetTechTech::firstOrNew([
                'name' => $item['name'],
            ]);
            $model->desc = $item['desc'];
            $model->per_fee = $item['per_fee'];
            $model->per_power = $item['per_power'];
            $model->save();
        }
    }

    public function __call($func, $args)
    {
        $this->all();
    }
}
