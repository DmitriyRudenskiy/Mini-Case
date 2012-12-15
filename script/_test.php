<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_NOTICE | E_STRICT);

define('BASE_PATH', dirname(dirname(__FILE__)));

set_include_path(
	get_include_path()
	. PATH_SEPARATOR . BASE_PATH . '/../_library/'
);

function geConfig()
{
	return array(
		'host' => 'webdb01.web.sibset.net',
		'username' => 'passport',
		'password' => 'inmRKY77EA',
		'dbname' => 'passport',
		'charset'=> 'UTF8'
	);
}

include 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->registerNamespace('Zend');   
Zend_Loader_Autoloader::getInstance()->registerNamespace('tools');

Zend_Db_Table_Abstract::setDefaultAdapter(
	new Zend_Db_Adapter_Pdo_Mysql(geConfig())
);

class Models_Remember extends Zend_Db_Table_Abstract
{
	protected $_name = 'passport_credibility_reminder';
}


$model = new Models_Remember();
$result = $model->fetchAll($model->select());
var_dump($result);



