<?php

namespace App\Cbr;

class CurrencyList
{

	protected $result;


	public function request()
	{
		$this->result = (new Request(Request::URL_CUR_LIST, [

		]))->request();
		return $this;
	}

	public function getResult()
	{
		libxml_use_internal_errors(true);
		$xml = new \SimpleXMLElement($this->result);
		$xpath = $xml->xpath('/Valuta/Item');

		$result = [];
		foreach ($xpath as $element) {
            $id = trim((string)$element->attributes()->ID);
		    $result[$id] = [
		        'cbr_code'  => $id,
		        'name'      => trim((string)$element->Name),
                'num_code'  => trim((string)$element->ISO_Num_Code),
                'char_code' => trim((string)$element->ISO_Char_Code),
                'nominal'   => (int)$element->Nominal,
			];
		}
		return $result;
	}

	public function getResultXML()
	{
		return $this->result;
	}
}
