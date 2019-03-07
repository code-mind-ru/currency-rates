<?php

namespace App\Http\Controllers;

use App\Cbr\CurrencyPeriod;
use App\Models\Currency;
use App\Models\CurrencyRatio;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome',[
            'currencies'=>Currency::all()
        ]);
    }

    public function generateReport(Request $request)
    {
        $validatedData = $request->validate([
            'fromDate'  => 'required|date',
            'toDate'    => 'required|date',
            'currency'  => 'required',
        ]);

        $fromDate = new DateTime($validatedData['fromDate']);
        $toDate = new DateTime($validatedData['toDate']);
        $currency = $validatedData['currency'];
        $currency = Currency::query()->where('cbr_code',$currency)->first();

        $result = (new CurrencyPeriod())
            ->setDateFrom($fromDate)
            ->setDateTo($toDate)
            ->setCurrency($currency->cbr_code)
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

        return new RedirectResponse('/currency/'.$currency->cbr_code.'/'.$fromDate->format('Y-m-d').'/'.$toDate->format('Y-m-d'));
    }



    public function currencyRatio($cbrCode,$fromDate,$toDate,Request $request)
    {
        $fromDate = new DateTime($fromDate);
        $toDate = new DateTime($toDate);

        $rates = CurrencyRatio::query()->where(['currency_ratios.cbr_code'=>$cbrCode])
            ->whereBetween('date',[$fromDate,$toDate])
            ->join('currencies', 'currencies.cbr_code', '=', 'currency_ratios.cbr_code')
            ->get(['*'])->all();


        return view('currencyRatios',[
            'currency'          =>  Currency::query()->where('cbr_code',$cbrCode)->first(),
            'currencyRatios'    =>  $rates
        ]);
    }



}
