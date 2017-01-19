<?php

namespace App\Console\Commands;

use App\Models\Config;
use App\Models\EventStandard;
use App\Models\FleetBodyWidget;
use App\Models\FleetTechTech;
use App\Models\Galaxy;
use App\Models\MilitaryRank;
use App\Models\Planet;
use App\Models\Quadrant;
use App\Models\Staff;
use App\Models\Story;
use App\Models\Union;
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

        $this->initNormalEvent();

        /**
         * 初始化星球
         */
        $this->initGalaxy();
        $this->initQuadrant();
        $this->initPlanet();

        /**
         * 初始化联盟
         */
        $this->initUnion();

        /**
         * 初始化军衔
         */
        $this->initMilitaryRank();

        $this->fleetBodyWidget();

        $this->fleetTechTech();
    }

    private function initStory()
    {
        foreach (g_load_import('story', __FUNCTION__) as $story) {
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
        foreach (g_load_import('config', __FUNCTION__) as $key => $value) {
            $model = Config::firstOrNew([
                'key' => $key,
            ]);
            $model->value = $value;
            $model->save();
        }
    }

    private function initGalaxy()
    {
        foreach (g_load_import('planet', __FUNCTION__) as $key => $value) {
            $model = Galaxy::firstOrNew([
                'coordinate' => $value['coordinate'],
            ]);
            $model->name = $value['name'];
            $model->save();
        }
    }

    private function initQuadrant()
    {
        foreach (g_load_import('planet', __FUNCTION__) as $key => $value) {
            $model = Quadrant::firstOrNew([
                'coordinate' => $value['coordinate'],
            ]);
            $model->name = $value['name'];
            $model->galaxy_id = $value['galaxy_id'];
            $model->save();
        }
    }

    private function initPlanet()
    {
        foreach (g_load_import('planet', __FUNCTION__) as $key => $value) {
            $model = Planet::firstOrNew([
                'coordinate' => $value['coordinate'],
            ]);
            $model->name = $value['name'];
            $model->quadrant_id = $value['quadrant_id'];
            $model->save();
        }
    }

    private function initUnion()
    {
        foreach (g_load_import('union', __FUNCTION__) as $key => $value) {
            $model = Union::firstOrNew([
                'name' => $value['name'],
            ]);
            $model->desc = $value['desc'];
            $model->occupied_planet = $value['occupied_planet'];
            $model->diplomacy = $value['diplomacy'];
            $model->save();
        }
    }

    private function initMilitaryRank()
    {
        foreach (g_load_import('military_rank', __FUNCTION__) as $key => $value) {
            $model = MilitaryRank::firstOrNew([
                'name' => $value['name'],
            ]);
            $model->need_contribution = $value['need_contribution'];
            $model->save();
        }
    }

    private function initHero()
    {
        foreach (g_load_import('hero', __FUNCTION__) as $hero) {
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

    private function initNormalEvent()
    {
        foreach (g_load_import('event', __FUNCTION__) as $event) {
            $model = EventStandard::firstOrNew([
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
