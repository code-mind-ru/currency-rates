<?php

namespace App\Cbr;

use DateInterval;
use DateTime;

class CurrencyPeriod
{

    /** @var DateTime */
    protected $dateFrom;
    /** @var DateTime */
    protected $dateTo;
    /** @var string  */
	private $currency;
    /** @var []|false */
	private $result;

    /**
     * CurrencyPeriod constructor.
     */
    public function __construct()
    {
        $this->dateFrom = (new DateTime('now'))->sub(new DateInterval("P1D"));
        $this->dateTo = new DateTime('now');
        $this->currency = '';
        $this->result = false;
    }


    /**
     * Установка начала периуда
     * @param DateTime $date
     * @return $this
     */
	public function setDateFrom(DateTime $date)
	{
		$this->dateFrom = $date;
		return $this;
	}

    /**
     * Установка окончания периуда
     * @param DateTime $date
     * @return $this
     */
	public function setDateTo(DateTime $date)
	{
		$this->dateTo = $date;
		return $this;
	}

    /**
     * Установка кода валюты в формате ЦБРФ
     * @param $cbrId - код валюты в cbr_id - R01436
     * @return $this
     */
	public function setCurrency(string $cbrId)
	{
		$this->currency = $cbrId;
		return $this;
	}

    /**
     * Выполнение запроса для получения значений валют
     * @return $this
     * @throws \Exception
     */
	public function request()
	{
		$this->result = (new Request(Request::URL_CUR_PERIOD, [
			'date_req1' => $this->dateFrom->format('d/m/Y'),
			'date_req2' => $this->dateTo->format('d/m/Y'),
			'VAL_NM_RQ' => $this->currency
		]))->request();

		return $this;
	}


    /**
     * Получение массива с данными о курсе валюты
     * @return array
     * @throws \Exception
     */
	public function getResult()
	{
        $xml = simplexml_load_string($this->result);
        $cbrCode = trim((string) $xml->attributes()['ID']);
        $result = [
            'currency'=>[
                'cbr_code' => $cbrCode
            ],
            'dateRange'=>[
                new DateTime((string)$xml->attributes()['DateRange1']),
                new DateTime((string)$xml->attributes()['DateRange2'])
            ],
            'records'=>[]
        ];

        foreach ($xml->xpath('Record') as $oRecord){
            $date = new DateTime(trim((string) $oRecord->attributes()['Date']));

            $result[$date->getTimestamp()] = [
                'date'          => $date,
                'cbr_code'      => $cbrCode,
                'nominal'       => (float)trim(str_replace(',', '.',$oRecord->Nominal)),
                'value'         => (float)trim(str_replace(',', '.', $oRecord->Value))
            ];

        }
		return $result;
	}

    /**
     * Получение оригинального xml
     * @return []|false
     */
    public function getResultXML()
    {
        return $this->result;
    }

}
