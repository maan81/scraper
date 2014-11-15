<?php

try{

	// Register an autoloader
	$loader = new \Phalcon\Loader();
	$loader->registerDirs(array(
		'../app/controllers/',
		'../app/models/',
		'../app/libraries/'
	))->register();


	// Create a DI
	$di = new Phalcon\DI\FactoryDefault();


	// // Setup the database service
	// $di->set('db',function(){

	// 	return new \Phalcon\Db\Adapter\Pdo\Mysql(array(

	// 			'host'     => 'localhost',
	// 			'username' => 'root',
	// 			'password' => 'password',
	// 			'dbname'   => 'phalcon'
	// 		));

	// });


	 // Setup the view components
	$di->set('view',function(){
		$view = new \Phalcon\Mvc\View();
		$view->setViewsDir('../app/views/');
		return $view;
	});


	// Setuip a base URI so that all generated URIs include the "phalcon" folder
	$di->set('url',function(){
		$url = new \Phalcon\Mvc\Url();
		$url->setBaseUri('/scraper/');
		return $url;
	});

	// Handle the request
	$application = new \Phalcon\Mvc\Application($di);

	echo $application->handle()->getContent();


} catch(\Phalcon\Exception $e){
	echo "PhalconExecption: ",$e->getMessage();
}
