<?php

class ControllerBase extends Phalcon\Mvc\Controller
{

    protected function getCurrentDir()
    {
        return dirname($_SERVER['PHP_SELF']);
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