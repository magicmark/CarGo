<?php

class UploadController extends ControllerBase
{

	private $validImageTypes = array(
		'image/jpeg',
		'image/png',
		'image/gif'
		);

	public function indexAction()
	{
		/*
		 * Testing
		 */
		
		//echo $this->autotrade->getDetails("S555MPL").'<br/>';
		//echo $this->autotrade->getDetails("LR12ZTO").'<br/>';
		//echo $this->autotrade->getDetails("P789PEG").'<br/>';

		/*
		$details = "";

		$platesNumber = array("LR12ZTO");

	 	foreach($platesNumber as $plate)
	 	{

		 	$details = $this->autotrade->getDetails($plate);	
		 	if($details != "")
		 		break;
	 	}

	 	$results = $this->autotrade->searchAdds($details);

	 	echo "i co?:/";
	 	var_dump($results);

	 	*/
	 	$name = "test4.jpg";
	 	$filePath = '/var/www/cargo/public/plates/'.$name;

		var_dump($filePath);
 		$platesNumber = $this->platesNumber->getPlateNumbers($filePath);

 		var_dump($platesNumber);
 		
 		/*$
 		 *  needed (?)
 		 */

 		/*

 			$platesJSON = json_encode(json_encode);
	 		echo $platesJSON;
	 	*/

	 	$details = "";

	 	foreach($platesNumber as $plate)
	 	{
		 	$details = $this->autotrade->getDetails($plate);	
		 	if($details != "")
		 		break;
	 	}

	 	if($details != "error404")
	 		$results = $this->autotrade->searchAdds($details);
	 	else
	 		$results = json_encode(array(
	 			"error" => "Plates not found"));

	 	var_dump($results);
	 	
	}

	public function carAction() {

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

	 	if(!empty($platesNumber);
		{

		 	foreach($platesNumber as $plate)
		 	{
			 	$details = $this->autotrade->getDetails($plate);	
			 	if($details != "")
			 		break;
		 	}

		 }

	 	if($details != "error404")
	 		$results = $this->autotrade->searchAdds($details);
	 	else
	 		$results = json_encode(array(
	 			"error" => "Plates not found"));

	}
}