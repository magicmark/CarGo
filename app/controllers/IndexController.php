<?php

class IndexController extends ControllerBase
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
		
		echo $this->getCurrentDir();

		//var_dump($this->request($this->authURL));
		//var_dump($this->platesNumber->getPlateNumbers("/Public/test3.jpg"));
	}
}