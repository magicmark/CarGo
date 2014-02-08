<?php

use Phalcon\Mvc\User\Component;

class Curl extends Component
{

	public function request($url, $type, $data = null)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url
		));

		return curl_exec($curl);
	}

}


?>