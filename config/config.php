<?php
return array(
	'bootstrap' => array(
		'path' => 'Bootstrap.php',
		'class' => 'Bootstrap'
	),
	
	'resources' => array(
		'frontController' => array(
			'controllerDirectory' => 'controllers',
			'throwExceptions' => DEBUG
		)
	),
		
	'prefix'   => 'qualitycase_',
	
	'cache' => array(
		'frontend' => array(
			'automatic_serialization' => true,
			'lifetime' => 600
		),
		'backend' => array(
			'automatic_cleaning_factor' => 1,
			'cache_id_prefix' => 'qualitycase_',
			'cache_dir' => APPLICATION_PATH . '/data/cache'
		)
	),

	'database' => array(
		'host'     => 'localhost',
		'username' => 'iotaru',
		'password' => 'hnXIJO6DG',
		'dbname'   => 'iotaru',
		'charset'  => 'UTF8'
	),
	
	'twig' => array(
		'layout' => '/views',
		'params'  => array(
			'debug'     => false,
			'strict_variables' => false,
			'autoescape' => false,
			'cache'   => APPLICATION_PATH . '/data/compile'
		)
	)
);
