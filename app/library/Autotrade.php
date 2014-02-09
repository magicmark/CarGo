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

		$plateNumberNew = substr($plateNumber,0,4)."%20".substr($plateNumber,4);

		$url = "http://www.carcheckuk.co.uk/results.php?vrm={$plateNumberNew}";
		//$url = urlencode($url);
		//echo $url;
		$data = array(
			"VRM" => $plateNumber);
		
		$htmlData = $this->curl->request($url,GET,false,false);
		$htmlData = str_replace("\n", "", $htmlData);
		$htmlData = str_replace("\r", "", $htmlData);
		$htmlData = str_replace("\t", "", $htmlData);

		//echo $htmlData;
		$patern = '@<td[^<>]*class="result_car_info"[^<>]*>(.*)</td>@';

		preg_match_all($patern,$htmlData,$matches);
		$patern = '@<br/>(.*)<br/><label>Make</label><br/>(.*)<br/><br/></td><td class="result_car_info"><label>Model</label><br/>(.*)<br/><br/><label>Colour</label><br/>(.*)<br/><br/>@';
		preg_match_all($patern,$matches[1][0],$matches);
		//var_dump($matches);

		if(!empty($matches[2]))
			$carData = array($matches[2][0],$matches[3][0],$matches[4][0]);
		else
			return "error404";

		//fixing color of the car

		//$carData[0] = substr($carData[0], 0, -1);
		var_dump($carData);

		return $carData;

	}

	public function searchAdds($data, $postcode = false)
	{
		
		$query = "Make={$data[0]}&Model={$data[1]}&Colour={$data[2]}";
		if($postcode)
		  $query .= "&Postcode={$postcode}";
		//$query = "options"	

		$requestURL = $this->baseURL."classified-adverts?".$query;

		$header = array("Access-Token: {$this->authToken}");
		$response = $this->curl->request($requestURL,"GET", $header);

		return $response;
	}
}




?>