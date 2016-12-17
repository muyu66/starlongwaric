<?php

Route::controller('auth', 'AuthController');

Route::resource('fleet', 'FleetController');
Route::controller('fleet_power', 'FleetPowerController');
Route::controller('fight', 'FightController');
Route::resource('fleet_log', 'FleetLogController');
Route::resource('enemy', 'EnemyController');
Route::get('enemy/random', 'EnemyController@getRandom');
