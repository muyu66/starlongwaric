<?php

namespace App\Console\Commands;

use App\Http\Controllers\FleetController;
use Illuminate\Console\Command;
use Artisan;
use Illuminate\Http\Request;
use Auth;

class DatabseCreate extends Command
{
    protected $signature = 'database:create';
    protected $description = 'database init';

    public function handle()
    {
        exec(
            implode("\n", [
                'cd ' . base_path(),
                'php artisan optimize',
            ])
        );

        // 创建数据库
        Artisan::call('migrate');

        // 管理员账号
        Artisan::call('user:create', [
            'email' => 'muyu.zhouyu@gmail.com',
            'password' => '111111',
        ]);

        // 固定数据填充
        Artisan::call('data:init');

        // 填充单元测试账号
        $this->unit();

        // 随机生成敌人
        Artisan::call('enemy:generate', [
            'amount' => '100',
        ]);

        // 随机生成船员
        Artisan::call('staff:generate', [
            'amount' => '20',
        ]);
    }

    private function unit()
    {
        // 创建用户
        Artisan::call('user:create', [
            'email' => 'zhouyu@muyu.party',
            'password' => '111111',
        ]);

        // 创建舰队
        Auth::loginUsingId(1);
        $ctl = new FleetController();
        $ctl->loc()->create(1, '王老五');

        Auth::loginUsingId(2);
        $ctl = new FleetController();
        $ctl->loc()->create(2, '胡汉三');

        // 填充它的数据
        Artisan::call('data:fix');
    }
}
