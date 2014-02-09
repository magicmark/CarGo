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
		$this->maps->getPostCode($lat,$long);
	}

	public function indexAction($lat = false, $long = false)
	{
		/*WW
		 * Testing
		 */
		
		$name = "test4.jpg";
		$filePath = '/var/www/cargo/public/plates/' . $name;

 		$platesNumber = $this->platesNumber->getPlateNumbers($filePath);
 		
 		var_dump($platesNumber);
 		
 		$details = "";

	 	if(!empty($platesNumber))
		{

		 	foreach($platesNumber as $plate)
		 	{
			 	$details = $this->autotrade->getDetails($plate);	
			 	if($details != "error404")
			 		break;
		 	}

		 }

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

	 	$resultsArray = json_decode($results,true);
		$resultsArray = array_merge($searchParam,$resultsArray);

		$results = json_encode($resultsArray);

		echo $results;

		// echo $this->autotrade->getDetails("LR12ZTO").'<br/>';
		//echo $this->autotrade->getDetails("P789PEG").'<br/>';
		//$postcode =  $this->maps->getPostCode("56","2.216688");
	 	//echo $this->maps->getPostCode("53.442775","-2.216688");
	}

	public function carAction($lat = false, $long = false) 
	{
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

 		//var_dump($platesNumber);
 		

	 	if(!empty($platesNumber))
		{

		 	foreach($platesNumber as $plate)
		 	{
			 	$details = $this->autotrade->getDetails($plate);	
			 	if($details != "error404")
			 		break;
		 	}

		 }

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

	 	$resultsArray = json_decode($results,true);
		$resultsArray = array_merge($searchParam,$resultsArray);

		$results = json_encode($resultsArray);

		echo $results;

	}

	public function testAction($lat = false, $long = false)
	{
		$details = "BLACK, 2005 AUDI A3 TYPE-R 3 DOOR HATCHBACK";
		$carData = explode(" ", $details);
		$carData[0] = substr($carData[0], 0, -1);

		$searchParam = array(
			"searchFilters" => $carData);

	
        if( $lat && $long )
	 	{
	        $postcode = $this->maps->getPostCode($lat, $long);
		    $results = $this->autotrade->searchAdds($carData, $postcode);
		}
		else
			$results = $this->autotrade->searchAdds($carData);
        #echo $results;
		$resultsArray = json_decode($results,true);
		$resultsArray = array_merge($searchParam,$resultsArray);

		$results = json_encode($resultsArray);

		echo $results;
	}
}