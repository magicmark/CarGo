<?php

class IndexController extends \Phalcon\Mvc\Controller
{

	private $authURL = "https://staging-cws.autotrader.co.uk/CoordinatedWebService/application/crs/connect/hacks/zDk2wtYF";

	private function request($url, $params = null)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url
		));

		return curl_exec($curl);
	}

	public function indexAction()
	{

		var_dump($this->request($this->authURL));
	}
}