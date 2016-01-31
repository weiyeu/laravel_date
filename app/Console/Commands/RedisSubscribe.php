<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Redis;

class RedisSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        function fff()
        {
            echo 'fffff';
        }

        $redis = Redis::connection();
        $redis->connect('http://localhost');
        $redis->subscribe('test-channel', 'fff');
//        $redis->publish('test-channel', 'fuck you all!!!');

        echo 'a';
        Redis::subscribe(['test-channel'], function ($message) {
            echo $message;
        });
    }
}
