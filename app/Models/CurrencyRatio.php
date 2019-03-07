<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyRatio extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'currency_ratios';

//    protected $casts = [
//        'date' => 'date',
//    ];
//    protected $dates = [
//        'date',
//    ];
    protected $fillable = ['cbr_code', 'price','date'];


    public function getDate(){
        return new \DateTime($this->attributes['date']);
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency','cbr_code','cbr_code');
    }
}
