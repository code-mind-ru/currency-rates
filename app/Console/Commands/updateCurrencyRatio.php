<?php

namespace App\Console\Commands;

use App\Cbr\CurrencyDaily;
use App\Cbr\CurrencyPeriod;
use App\Models\Currency;

use App\Models\CurrencyRatio;
use Illuminate\Console\Command;

class updateCurrencyRatio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateCurrencyRatio 
                    {--currency=all : Iso Code валюты } 
                    {--date=now : Дата для которой обновить курс}
                    {--dateTo= : Дата окончания интервала для которой обновить курс}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update currency ratio from cb rf';

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

        $currencyCode = trim($this->option('currency'));
        $date = new \DateTime($this->option('date'));
        $dateTo = ($this->option('dateTo')) ? new \DateTime($this->option('dateTo')) : false;


        $aCode = [];
        if($currencyCode=='all'){
            $currencies = Currency::all();
        }else{
            $currencies = Currency::query()->where('char_code','=',$currencyCode)->get();
        }
        foreach ($currencies as $currency){
            $aCode[] = $currency->cbr_code;
        }


        if($dateTo){
            foreach ($aCode as $code){
                if($code and trim($code)!=''){
                    $this->parseCurrency($code,$date,$dateTo);
                }
            }
        }else{
            $result = (new CurrencyDaily())
                ->setDate($date)
                ->setCodes($aCode)
                ->request()
                ->getResult();
            foreach ($result['records'] as $record){
                $currency = Currency::query()->firstOrCreate(
                    [
                        'cbr_code'  => $record['cbr_code']
                    ],
                    [
                        'cbr_code'  => $record['cbr_code'],
                    ]
                );
                $currency->num_code  = $record['num_code'];
                $currency->char_code = $record['char_code'];
                $currency->nominal   = $record['nominal'];
                $currency->name      = $record['name'];
                $currency->save();

                $currencyRatio = CurrencyRatio::query()->firstOrCreate(
                    [
                        'cbr_code'  =>  $record['cbr_code'],
                        'date'      =>  $record['date']->format('Y-m-d')
                    ],
                    [
                        'cbr_code'  => $currency->cbr_code,
                        'date'      => $record['date']->format('Y-m-d'),
                    ]
                );
                $currencyRatio->price = $record['value'];
                $currencyRatio->save();
            }
        }
        $this->info("Курс обновлен!");
    }


    /**
     * Обновление валюты для периуда
     * @param string $cbrCode
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @return bool
     * @throws \Exception
     */
    protected function parseCurrency(string $cbrCode, \DateTime $dateFrom, \DateTime $dateTo){
        $result = (new CurrencyPeriod())
            ->setDateFrom($dateFrom)
            ->setDateTo($dateTo)
            ->setCurrency($cbrCode)
            ->request()
            ->getResult();

        foreach ($result['records'] as $record){
            $currencyRatio = CurrencyRatio::query()->firstOrCreate(
                [
                    'cbr_code' =>  $record['cbr_code'],
                    'date'      =>  $record['date']->format('Y-m-d')
                ],
                [
                    'cbr_code'  => $record['cbr_code'],
                    'date'      => $record['date']->format('Y-m-d'),
                    'price'     => $record['value']
                ]
            );
            $currencyRatio->price = $record['value'];
            $currencyRatio->date = $record['date']->format('Y-m-d');
            $currencyRatio->save();
        }
        return true;
    }
}
