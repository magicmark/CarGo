<?php

class UploadController extends ControllerBase
{

	private $validImageTypes = array(
		'image/jpeg',
		'image/png',
		'image/gif'
		);

	public function locationAction($lat, $long)
	{
		echo $this->maps->getPostCode($lat,$long);
	}

	public function indexAction()
	{
		/*
		 * Testing
		 */
		
		//echo $this->autotrade->getDetails("S555MPL").'<br/>';
		// echo $this->autotrade->getDetails("LR12ZTO").'<br/>';
		//echo $this->autotrade->getDetails("P789PEG").'<br/>';
		$postcode =  $this->maps->getPostCode("56","2.216688");
	 	echo $this->maps->getPostCode("53.442775","-2.216688");
	}

	public function carAction($lat = false, $long = false) {

    	if ($this->request->hasFiles() != true) 
    	{
    		echo json_encode(array('error' => 'No image uploaded!'));
    		return;
   		 }

        // We only want the first file. Gracefully ignore any extra files as that would be errant behaviour.
        $file = reset($this->request->getUploadedFiles());
 		
 		$type = ($file->getRealType() != '') ? $file->getRealType() : $file->getType();

 		if (!in_array($type, $this->validImageTypes)) {
 			echo json_encode(array('error' => 'Image type not allowed!'));
 			return;
 		}

 		$name = md5(microtime() . 'Cars.com rule!' . mt_rand()).'.'.pathinfo($file->getName(), PATHINFO_EXTENSION);
 		
 		$filePath = '/var/www/cargo/public/plates/' . $name;
 		$file->moveTo($filePath);

 		$platesNumber = $this->platesNumber->getPlateNumbers($filePath);

 		var_dump($platesNumber);
 		
 		/*$
 		 *  needed (?)
 		 */

 		/*

 			$platesJSON = json_encode(json_encode);
	 		echo $platesJSON;
	 	*/


	 	if(!empty($platesNumber))
		{

		 	foreach($platesNumber as $plate)
		 	{
			 	$details = $this->autotrade->getDetails($plate);	
			 	if($details != "error404")
			 		break;
		 	}

		 }

		if( $lat && $long )
	        $postcode = $this->maps->getPostCode($lat, $long);

	 	if($details != "error404")
	 	{
	 		if( $lat && $long )
	 		{
	          $postcode = $this->maps->getPostCode($lat, $long);
	 		  $results = $this->autotrade->searchAdds($details, $postcode);
	 		}
	 		else
	 		{
	 		  $results = $this->autotrade->searchAdds($details);
	 		}
	 	}
	 	else
	 		$results = json_encode(array(
	 			"error" => "Plates not found"));

	}

	public function testAction()
	{
		$details = "BLACK, 2005 HONDA CIVIC TYPE-R 3 DOOR HATCHBACK";
		$carData = explode(" ", $details);
		$carData[0] = substr($carData[0], 0, -1);

		$searchParam = array(
			"searchFilters" => $carData);

	

		$results = $this->autotrade->searchAdds($carData);

		$resultsArray = json_decode($results,true);
		$resultsArray = array_merge($searchParam,$resultsArray);

		$results = json_encode($resultsArray);

		echo $results;
	}
}