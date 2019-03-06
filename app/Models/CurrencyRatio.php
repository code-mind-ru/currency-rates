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

    protected $fillable = ['cbr_code', 'price','date'];


    public function currency()
    {
        return $this->belongsTo('App\Currency','cbr_code','cbr_code');
    }
}
