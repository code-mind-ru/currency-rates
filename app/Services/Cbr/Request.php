<?php

namespace App\Cbr;

class Request
{
	private $url;

    const URL_CUR_LIST = 'http://www.cbr.ru/scripts/XML_valFull.asp';
	const URL_CUR_DAILY = 'http://www.cbr.ru/scripts/XML_daily.asp';
	const URL_CUR_PERIOD = 'http://www.cbr.ru/scripts/XML_dynamic.asp';


    /**
     * Request constructor.
     * @param $url
     * @param $data
     */
    public function __construct($url, $data)
	{
		foreach ($data as $key => $value) {
			if (empty($value)) {
				unset($data[$key]);
			}
		}

		$this->url = $url.((empty($data)) ? '' : '?'.http_build_query($data));
	}

    /**
     * @return bool|string
     * @throws \Exception
     */
    public function request()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		$error = curl_error($ch);

		curl_close($ch);

		if ($error) {
			throw new \Exception($error);
		}

		if ($info['http_code'] == 404) {
			throw new \Exception('Неверный URL');
		}

		return $result;
	}
}
