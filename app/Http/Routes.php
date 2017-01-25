<?php

Route::get('enemies/randoms', 'EnemyController@getRandoms');
Route::get('enemies/random', 'EnemyController@getRandom');

Route::controller('fight', 'FightController');

Route::post('fleet_bodies/all', 'FleetBodyController@postAll');
Route::resource('fleet_bodies', 'FleetBodyController');

Route::post('fleet_teches/all', 'FleetTechController@postAll');

Route::post('fleet_configs/commander_style', 'FleetConfigController@postCommanderStyle');
Route::resource('fleet_configs', 'FleetConfigController');


Route::resource('stories', 'StoryController');

Route::resource('users', 'UserController');

Route::resource('fight_logs', 'FightLogController');

Route::controller('staff', 'StaffController');

Route::resource('event_standards', 'EventStandardController');

Route::controller('friend', 'FriendController');

Route::controller('message', 'MessageController');

Route::controller('test', 'TestController');

Route::resource('galaxies', 'GalaxyController');
Route::resource('quadrants', 'QuadrantController');
Route::resource('planets', 'PlanetController');

Route::resource('unions', 'UnionController');

Route::resource('military_ranks', 'MilitaryRankController');






Route::get('/', function () {
    return ['code' => 200, 'msg' => 'welcome'];
});

Route::get('time', function () {
    return ['code' => 200, 'msg' => g_get_star_date()];
});

Route::controller('auth', \App\Http\Controllers\AuthController::class());

Route::resource('fleets', \App\Http\Controllers\FleetController::class());
Route::resource('fleets.bodies', \App\Http\Controllers\FleetBodyController::class());
Route::resource('fleets.teches', \App\Http\Controllers\FleetTechController::class());
Route::resource('fleets.events', \App\Http\Controllers\FleetEventController::class());

Route::resource('enemies', \App\Http\Controllers\EnemyController::class());

