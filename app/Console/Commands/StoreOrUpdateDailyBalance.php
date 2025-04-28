<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DailyBalance\DailyBalanceService;
use Nette\Utils\Random;

class StoreOrUpdateDailyBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-or-update-daily-balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(DailyBalanceService $dailyBalanceService)
    {
        $dailyBalanceService->storeOrUpdate($this->dailyBalanceData());
    }
    private function dailyBalanceData(): array
    {
        $dailyBalanceData = [];
        for ($i = 0; $i < 100; $i++) {
            $dailyBalanceData[] = [
                'date' => now()->subDays($i)->format('Y-m-d'),
                'account_number' => $i,
                'iban' => Random::generate(16, '0-9'),
                'balance' => rand(1000, 10000),
                'name' => 'John Doe',
                'currency' => 'EUR',
            ];
        }
        return $dailyBalanceData;
    }
}
