<?php

class AutotradeController extends \Phalcon\Mvc\Controller
{

	private $authURL = "https://staging-cws.autotrader.co.uk/CoordinatedWebService/application/crs/connect/hacks/zDk2wtYF";

	private function request($url, $params = null)
	{
		$curl = curl_init();
		$data = "VRM=S555MPL";

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url
		));

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		return curl_exec($curl);
	}

	public function indexAction()
	{

		echo ($this->request("http://www.vehiclecheck.co.uk"));
	}
}
