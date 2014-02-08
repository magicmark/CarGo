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

		//var_dump($this->request($this->authURL));
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
 		
 		$filePath = $this->getCurrentDir().'/plates/' . $name;
 		$file->moveTo($filePath);


	}
}