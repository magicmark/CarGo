<?php

use Phalcon\Mvc\User\Component;

class Autotrade extends Component
{
	private $authURL = "https://staging-cws.autotrader.co.uk/CoordinatedWebService/application/crs/connect/hacks/zDk2wtYF";

	define("POST", "POST");
	define("GET". "GET");

	private $authToken;

	public function __construct()
	{
		$token = $this->curl
		              ->request($authURL,GET);
		$this->token = $token;
	}

	public function search($data)
	{
		$response;


		return $response;
	}
}




?>