<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class getCustomer_redis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getCustomer_redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pattern = 'national_id_*';
        $keys = Redis::keys($pattern);
        dd($keys);
        // dd(Redis::get('national_id_12345678913'));
        dd($values = Redis::mget($keys));

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = Redis::get($key);
            print_r($data);
        }
    }
}
