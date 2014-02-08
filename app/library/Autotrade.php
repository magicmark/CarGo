<?php

use Phalcon\Mvc\User\Component;

class Autotrade extends Component
{
	private $authURL = "https://staging-cws.autotrader.co.uk/CoordinatedWebService/application/crs/connect/hacks/zDk2wtYF";

	private $authToken;

	public function __construct()
	{
		define("POST", "POST");
		define("GET", "GET");

		$token = $this->curl
		              ->request($this->authURL,GET);
		$this->token = $token;
	}


	public function getDetails($plateNumber)
	{
		$url = "www.vehiclecheck.co.uk";
		$data = array(
			"VRM" => $plateNumber);
		
		$htmlData = $this->curl->request($url,POST,$data);

		$patern = '@<div[^<>]*class="vehicleDetail"[^<>]*>(.*)</div>@';

		preg_match_all($patern,$htmlData,$matches);

		var_dump($matches[1]);

	}

	public function search($data)
	{
		$response;


		return $response;
	}
}




?>