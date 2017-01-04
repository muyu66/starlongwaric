<?php

Route::controller('auth', 'AuthController');

Route::resource('fleet', 'FleetController');
Route::resource('fleet_body', 'FleetBodyController');
Route::post('fleet_body/all', 'FleetBodyController@postStoreAll');
Route::resource('fleet_tech', 'FleetTechController');
Route::post('fleet_tech/all', 'FleetTechController@postStoreAll');
Route::resource('story', 'StoryController');
Route::resource('user', 'UserController');

Route::resource('fleet_config', 'FleetConfigController');
Route::post('fleet_config/play_time', 'FleetConfigController@postUpdatePlayTime');

Route::controller('fleet_power', 'FleetPowerController');
Route::controller('fight', 'FightController');
Route::resource('fleet_log', 'FleetLogController');
Route::resource('enemy', 'EnemyController');
Route::get('enemy/random', 'EnemyController@getRandom');
