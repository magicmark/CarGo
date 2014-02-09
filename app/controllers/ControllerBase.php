<?php

class ControllerBase extends Phalcon\Mvc\Controller
{

    protected function getCurrentDir()
    {

        return dirname($_SERVER['DOCUMENT_ROOT'])."/www/cargo";
    }

    protected function forward($uri){
    	$uriParts = explode('/', $uri);
    	return $this->dispatcher->forward(
    		array(
    			'controller' => $uriParts[0], 
    			'action' => $uriParts[1]
    		)
    	);
    }
}