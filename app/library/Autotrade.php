<?php

use Phalcon\Mvc\User\Component;

class Autotrade extends Component
{
	private $authURL = "https://staging-cws.autotrader.co.uk/CoordinatedWebService/application/crs/connect/hacks/zDk2wtYF";
	private $baseURL = "https://staging-cws.autotrader.co.uk/CoordinatedWebService/application/crs/sss/";
	private $authToken;

	public function __construct()
	{
		define("POST", "POST");
		define("GET", "GET");

		$token = $this->curl
		              ->request($this->authURL,GET);

		$this->authToken = $token;
	}


	public function getDetails($plateNumber)
	{
		$url = "www.vehiclecheck.co.uk";
		$data = array(
			"VRM" => $plateNumber);
		
		$htmlData = $this->curl->request($url,POST,false,$data);

		$patern = '@<div[^<>]*class="vehicleDetail"[^<>]*>(.*)</div>@';

		preg_match_all($patern,$htmlData,$matches);

		var_dump($matches);
		
		if(!empty($matches[1]) && count($matches[1]) != 0))
			$carData = explode(" ", $matches[1][0],6);
		else
			return "error404";

		//fixing color of the car

		$carData[0] = substr($carData[0], 0, -1);

		return $carData;

	}

	public function searchAdds($data)
	{
		
		$query = "Make={$data[2]}&Model={$data[3]}&Colour=Silver";

		$requestURL = $this->baseURL."classified-adverts?".$query;

		var_dump($this->authToken);
		$header = array("Access-Token: {$this->authToken}");
		$response = $this->curl->request($requestURL,"GET", $header);

		var_dump($response);

		return $response;
	}
}




?>