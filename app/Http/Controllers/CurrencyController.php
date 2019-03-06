<?php

namespace App\Http\Controllers;

use App\Cbr\CurrencyDaily;
use App\Cbr\CurrencyList;
use App\Cbr\CurrencyPeriod;
use App\Models\Currency;
use App\Models\CurrencyRatio;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('currency',[
            'currencies'=>Currency::all()
        ]);
    }

}
