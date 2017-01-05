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
Route::resource('fleet_log', 'FleetLogController');




Route::get('enemies/randoms', 'EnemyController@getRandoms');
Route::get('enemies/random', 'EnemyController@getRandom');
Route::resource('enemies', 'EnemyController');

Route::controller('fight', 'FightController');
