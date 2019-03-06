<?php

namespace App\Console\Commands;

use App\Cbr\CurrencyList;
use App\Models\Currency;
use Illuminate\Console\Command;

class importCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importCurrencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import currencies list from cbr';

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
        $aCurrencies = (new CurrencyList())->request()->getResult();
        $i=0;
        foreach ($aCurrencies as $aCurrency){
            if(!$aCurrency['cbr_code']) continue;

            $i++;
            $currency = Currency::query()->firstOrCreate(
                [
                    'cbr_code'  => $aCurrency['cbr_code']
                ],
                [
                    'cbr_code'  => $aCurrency['cbr_code'],
                    'name'      => ($aCurrency['name']) ? $aCurrency['name'] : null,
                    'nominal'   => ($aCurrency['num_code']) ? (int) $aCurrency['num_code'] : 0,
                    'char_code' => ($aCurrency['char_code']) ? $aCurrency['char_code'] : null,
                    'num_code'  => ($aCurrency['num_code']) ? (int) $aCurrency['num_code'] : null,
                ]
            );
        }
        $this->info("Проимпортировано {$i} наименований валют!");
    }
}
