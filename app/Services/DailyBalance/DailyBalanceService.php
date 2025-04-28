<?php

namespace App\Services\DailyBalance;

use App\Models\DailyBalance;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Diff\Chunk;

class DailyBalanceService
{
    public function storeOrUpdate(array $data)
    {
        /**
         * @var array $dailyBalance
         * @var bool $exists
         * @var array $data
         * @return void
         */
        // dd($data);
        DB::enableQueryLog();
        foreach (array_chunk($data, 20) as $chunk) {

            $exists = DailyBalance::query()
                ->upsert(
                    $chunk,
                    ['date', 'account_number'],
                    ['balance', 'name', 'currency', 'iban']
                );
        }

        // $exists = DailyBalance::query()
        //     ->upsert(
        //         $data,
        //         ['date', 'account_number'],
        //         ['balance', 'name', 'currency', 'iban']
        //     );
        // ->updateOrCreate([
        //     'date' => $dailyBalance['date'],
        //     'account_number' => $dailyBalance['account_number'],
        //     'balance' => $dailyBalance['balance'],
        //     'name' => $dailyBalance['name'],
        //     'currency' => $dailyBalance['currency'],
        //     'iban' => $dailyBalance['iban'],

        // ]);
        // $exists = DailyBalance::query()
        //     ->where('date', $dailyBalance['date'])
        //     ->where('account_number', $dailyBalance['account_number'])
        //     ->exists();

        // if ($exists) {
        //     DailyBalance::query()
        //         ->where('date', $dailyBalance['date'])
        //         ->where('account_number', $dailyBalance['account_number'])
        //         ->update(['balance' => $dailyBalance['balance']]);
        // } else {
        //     DailyBalance::query()
        //         ->create([
        //             'date' => $dailyBalance['date'],
        //             'account_number' => $dailyBalance['account_number'],
        //             'balance' => $dailyBalance['balance'],
        //             'name' => $dailyBalance['name'],
        //             'currency' => $dailyBalance['currency'],
        //             'iban' => $dailyBalance['iban'],
        //         ]);
        // }

        dd(DB::getQueryLog());
    }
}
