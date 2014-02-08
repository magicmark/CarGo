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
		echo $this->autotrade->getDetails("LR12ZTO").'<br/>';
		echo $this->autotrade->getDetails("P789PEG").'<br/>';
		echo $this->autotrade->getDetails("S555MPL").'<br/>';

	}

	public function carAction() {

    if ($this->request->hasFiles() != true) {
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
 		
 		$filePath = $this->getCurrentDir().'/public/plates/' . $name;
 		$file->moveTo($filePath);

 		$platesNumber = $this->platesNumber->getPlateNumbers($filePath);

 		
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
		 	$details = $this->autoTrade->getDetails($plate);	
		 	if($details != "")
		 		break;
	 	}

	 	$results = $this->autoTrade->serach($details);

	 	$resultsJSON = json_encode($results);

	 	echo $resultsJSON;
	}
}