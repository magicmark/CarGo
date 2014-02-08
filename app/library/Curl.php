<?php

use Phalcon\Mvc\User\Component;

class Curl extends Component
{


	public function request($url, $type, $data = null)
	{
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);
		
		if($type == "POST"){
			$data = http_build_query($data);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url
		));

		return curl_exec($curl);
	}

}


?>