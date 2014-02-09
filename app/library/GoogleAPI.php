<?php

use Phalcon\Mvc\User\Component;

class GoogleAPI extends Component
{
	public function getPostCode($lat, $long)
	{
		$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$long."&sensor=false";
		$jsonData = $this->curl->request($url,'GET',false,array());
		$data = json_decode($jsonData);
		// var_dump($data->{"results"}[0]->{"address_components"}[7]->long_name);
		$compos1 = $data->{"results"};
		foreach ($compos1 as $compoTemp) 
		{
			$compos = $compoTemp->{"address_components"};
			foreach ($compos as $element) 
			{
				if( $element->{"types"}[0] == "postal_code" )
				{
					return preg_replace('/\s/', '', $element->{"long_name"});
				}
			}
		}
        return "Error with lattitude and longitude!";
	}
}

?>