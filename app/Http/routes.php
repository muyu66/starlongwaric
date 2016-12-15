<?php

Route::controller('auth', 'AuthController');

Route::resource('fleet', 'FleetController');
Route::controller('fleet_power', 'FleetPowerController');
Route::controller('fight', 'FightController');