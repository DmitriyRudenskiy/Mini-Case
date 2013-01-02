<?php
return array(
	'bootstrap' => array(
		'path' => 'Bootstrap.php',
		'class' => 'Bootstrap'
	),
	
	'resources' => array(
		'frontController' => array(
			'controllerDirectory' => 'controllers',
			'displayExceptions' => 1,
			'throwExceptions' => 0,
			'useDefaultControllerAlways' => 1,
			'defaultControllerName' => 'error',
			'defaultAction' => 'error'
		)
	),
		
	'prefix'   => 'passport_',
	
	'cache' => array(
		'frontend' => array(
			'automatic_serialization' => true,
			'lifetime' => 7200
		),
		'backend' => array(
			'automatic_cleaning_factor' => 1,
			'cache_id_prefix' => 'passport_',
			'cache_dir' => APPLICATION_PATH . '/public/cache'
		)
	),

	'database' => array(
		'host'     => 'localhost',
		'username' => 'login',
		'password' => 'password',
		'dbname'   => 'name',
		'charset'  => 'UTF8'
	),
	
	'routes' => array(
		'base' => array(
			'route' => '/:controller/:action/:id',
			'defaults' => array(
				'controller' => 'index',
				'action' => 'index',
				'id' => 0
			)
		),
	),
	
	'twig' => array(
		'layout' => '/views',
		'params'  => array(
			'debug'     => false,
			'strict_variables' => false,
			'autoescape' => false,
			'cache'   => APPLICATION_PATH . '/public/compile'
		)
	)
);
