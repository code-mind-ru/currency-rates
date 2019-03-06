<?php

namespace App\Cbr;

use DateTime;

class CurrencyDaily
{
    /** @var DateTime */
    protected $date;
    /** @var DateTime */
    protected $resultDate;
    /** @var [] */
	protected $codes;
    /** @var []|false */
    protected $result;

    /**
     * CurrencyDaily constructor.
     *
     */
    public function __construct()
    {
        $this->date = new DateTime('now');
        $this->codes = [];
        $this->result = false;
    }


    /**
     * Установка даты для получения курса
     * @param DateTime $date
     * @return $this
     */
    public function setDate(DateTime $date)
	{
	    $this->date = $date;
		return $this;
	}

    /**
     * Установка кодов в iso или cbrId формате для фильтрации результата
     * @param array $codes - ['NOK','USD','R01535']
     * @return $this
     */
    public function setCodes(array $codes)
    {
        $this->codes = $codes;
        return $this;
    }

    /**
     * Вернуть строковое представление даты для результата
     * @param string $format
     * @return mixed
     */
    public function getResultDate($format = 'Y-m-d')
	{
		return $this->resultDate->format($format);
	}

    /**
     * Выполнение запроса для получения значений валют
     * @return $this
     * @throws \Exception
     */
    public function request()
	{
		$this->result = (new Request(Request::URL_CUR_DAILY, [
			'date_req' => $this->date->format("d/m/Y")
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
        $this->resultDate = new DateTime(str_replace('.0', '.', (string)$xml->attributes()['Date']));
        $result = [
            'resultDate'=>$this->resultDate,
            'records'=>[]
        ];

        if ($this->codes) {
            foreach ($this->codes as $code) {
                foreach ($xml->xpath('//Valute[@ID="' . $code . '" or CharCode="' . $code . '"]') as $oValue) {
                    $cbrCode = trim((string)$oValue->attributes()['ID']);
                    $result['records'][$cbrCode] = $this->parseElement($oValue);
                }
            }
        } else {
            foreach ($xml->xpath('//Valute') as $oValue) {
                $cbrCode = trim((string)$oValue->attributes()['ID']);
                $result['records'][$cbrCode] = $this->parseElement($oValue);
            }
        }
        return $result;
    }

    /**
     * Преобразование в массив данных для конкретной валюты
     * @param \SimpleXMLElement $oValue
     * @return array
     */
    protected function parseElement(\SimpleXMLElement $oValue){
        $cbrCode = trim((string)$oValue->attributes()['ID']);
        $charCode = trim((string)$oValue->CharCode);
        return [
            'cbr_code'  => $cbrCode,
            'num_code'  => trim((string)$oValue->NumCode),
            'char_code' => $charCode,
            'nominal'   => (float)trim(str_replace(',', '.', $oValue->Nominal)),
            'name'      => trim((string)$oValue->Name),
            'value'     => (float)(str_replace(',', '.', $oValue->Value))
        ];
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
