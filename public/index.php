<?php 

try 
{
	$config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');
	
	$loader = new \Phalcon\Loader();
	$loader->registerDirs(array(
		__DIR__ . $config->application->controllersDir,
		__DIR__ . $config->application->pluginsDir,
		__DIR__ . $config->application->libraryDir,
		__DIR__ . $config->application->modelsDir
	))->register();

	$di = new Phalcon\DI\FactoryDefault();

	$di->set('view', function() use ($config){
    	$view = new \Phalcon\Mvc\View();
        $view->setViewsDir(
        	__DIR__  . $config->application->viewsDir);
        return $view;
    });

    $di->set('url', function() use ($config){
        $url = new \Phalcon\Mvc\Url();
     	$url->setBaseUri(
        	$config->application->baseUri);
        return $url;
    });
	
	/**
	 * Getin the plates number 
	 * from the image
	 */
	$di->set('platesNumber', function(){
		return new PlatesNumber();
	});

	$application = new \Phalcon\Mvc\Application($di);
	$application->setDI($di);

    echo $application->handle()->getContent();
} 	
catch(\Phalcon\Exception $e)
{
     echo "PhalconException: Niggas in paris:", $e->getMessage();
}

?>

