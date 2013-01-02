<?php
date_default_timezone_set('Asia/Novosibirsk');

define('APPLICATION_PATH', dirname(dirname(__FILE__)));
define('BASE_PATH', APPLICATION_PATH . '/modules/default');
define('DEBUG', 1);

set_include_path(
	get_include_path() 
	. PATH_SEPARATOR . APPLICATION_PATH . '/../_library/'
	. PATH_SEPARATOR . APPLICATION_PATH
	. PATH_SEPARATOR . BASE_PATH
);

include 'Zend/Application.php';
include 'Zend/Config.php';

$application = new Zend_Application(
		'',
		new Zend_Config(include APPLICATION_PATH . '/config/config.php')
);
$application->bootstrap()->run();