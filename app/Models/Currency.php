<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Currency
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CurrencyRatio[] $rates
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Currency query()
 * @mixin \Eloquent
 */
class Currency extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
 //   protected $table = 'currencies';

    protected $guarded = array('id');

    protected $fillable = [
        'name',
        'nominal',
        'num_code',
        'char_code',
        'cbr_code',
    ];

    protected $attributes = [
        'name'      =>  null,
        'nominal'   =>  0,
        'num_code'  =>  null,
        'char_code' =>  null,
        'cbr_code'  =>  null,
    ];
    /**
     * Define a one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates()
    {
        return $this->hasMany('App\Models\CurrencyRatio','cbr_code','cbr_code');
    }

    /**
     * @param \DateTime $date
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function rate(\DateTime $date){
        return $this->rates()->where("date",'=',$date)->first();
    }


    /**
     * @param \DateTime $date
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function lastRate(){
        //dd($this->rates()->orderBy("date",'desc')->limit(1)->get()->first());
        return $this->rates()->orderBy("date",'desc')->limit(1)->get()->first();
    }
}
