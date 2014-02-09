<?php

use Phalcon\Mvc\User\Component;

class Curl extends Component
{


	public function request($url, $type, $header = false, $data = false)
	{
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLINFO_HEADER_OUT, true);	

		if($type == "POST" && $data != false)
		{
			$data = http_build_query($data);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}

		var_dump($header);
		if($header)
		{
			curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
		}

		$output = "";
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url
		));

		$response = curl_exec($curl);
		$output = curl_getinfo($curl, CURLINFO_HEADER_OUT);
		//var_dump($output);

		return $response;
	}

}


?>