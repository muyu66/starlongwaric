<?php

namespace App\Console\Commands;

use App\Http\Controllers\AuthController;
use App\Http\Logics\AuthLogic;
use Illuminate\Console\Command;

class UserCreate extends Command
{
    protected $signature = 'user:create {email} {password?}';
    protected $description = 'create user quickly';

    public function handle()
    {
        $loc = new AuthLogic();
        $loc->create([
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
        ]);
    }
}
