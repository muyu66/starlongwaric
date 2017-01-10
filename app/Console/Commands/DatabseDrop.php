<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DatabseDrop extends Command
{
    protected $signature = 'database:drop';
    protected $description = 'database drop';

    public function handle()
    {
        $databse = config('database.connections.mysql.database');
        if ($this->confirm("你确定要删除 $databse 里的所有表吗 [y|N]")) {
            DB::select('drop database ' . $databse);
            DB::select('create database ' . $databse);
        }
        $this->info('no change');
    }
}
