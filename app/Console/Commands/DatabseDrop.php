<?php

namespace App\Console\Commands;

use App\Http\Commons\Redis;
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
            $this->info('完成');
        }
        if ($this->confirm("你确定要删除 Redis 里的指定 DB 吗 [y|N]")) {
            $redis = new Redis();
            $redis->flushDb();
            $this->info('完成');
        }
    }
}
