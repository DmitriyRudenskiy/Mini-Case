<?php

 /**
  * Controller
  *
  * Аукцион
  *
  * @package	bonus.211.ru
  * @author		Dmitry Rudensky <dmitrij.rudenskij@gmail.com>
  * @copyright	(c) 2012 Quality Case
  * @version	1.0
  * @license	http://www.qualitycase.ru/license
  * @link		http://www.qualitycase.ru/
  */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected $_cache;
	
	public function _initPrefix()
	{
		define('PREFIX', $this->getOption('prefix'));
	}
	
	public function _initNamespaces()
	{
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Zend');
		$autoloader->registerNamespace('Twig');
		$autoloader->registerNamespace('tools');
	}
	
	public function _initSession()
	{
		Zend_Session::start();
		
		$session = new Zend_Session_Namespace(
				PREFIX . 'fronted',
				Zend_Session_Namespace::SINGLE_INSTANCE
		);
		
		Zend_Registry::set('session', $session);
		
		Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session(PREFIX.'fronted_auth'));
	}
	
	protected function _initCache()
	{
		$config = $this->getOption('cache');

		// включение режима отладки
		if (DEBUG) {
			$config['frontend']['caching'] = false;
		}
	
		$this->_cache = Zend_Cache::factory(
			'Core',
			'File',
			$config['frontend'],
			$config['backend']
		);
	
		Zend_Registry::set('cache', $this->_cache);
	}
	
	protected function _initConfig()
	{
		if(!$config = $this->_cache->load('config')) {
	
			$config = new Zend_Config_Ini(BASE_PATH . '/configs/application.ini');
			$config = $config->toArray();
	
			$this->_cache->save($config, 'config');
		}
	
		Zend_Registry::set('config', $config);
	}
	
	/**
	 * Set up form and model folders
	 */
	protected function _initResources()
	{
		$resourceLoader = new Zend_Loader_Autoloader_Resource(
			array(
				'basePath'  => dirname(__FILE__),
				'namespace' => '',
				'resourceTypes' => array(
					'acl' => array(
						'path' => 'acls',
						'namespace' => 'Acl'
					),
					'controller' => array(
						'path' => 'controllers',
						'namespace' => 'Controller'
					),
					'model' => array(
						'path' => 'models',
						'namespace' => 'Model'
					),
					'model' => array(
						'path' => 'models',
						'namespace' => 'Model'
					),
					'model' => array(
						'path' => 'models',
						'namespace' => 'Model'
					)
				)
			)
		);
		$resourceLoader->addResourceType('form', 'forms/', 'Form');
		$resourceLoader->addResourceType('model', 'models/', 'Model');
		$resourceLoader->addResourceType('plugin', 'plugins/', 'Plugin');
	}
	
	protected function _initRouter()
	{
		if(!$config = $this->_cache->load('routes')) {

			$config = new Zend_Config_Ini(BASE_PATH . '/configs/routers.ini');
		
			$this->_cache->save($config, 'routes');
		}
		
		$router = Zend_Controller_Front::getInstance()->getRouter();
		$router->removeDefaultRoutes();
		$router->addConfig($config);
	}

	public function _initDefaultDbAdapter()
	{
		Zend_Db_Table_Abstract::setDefaultAdapter(
			new Zend_Db_Adapter_Pdo_Mysql($this->getOption('database'))
		);
		
		Zend_Db_Table::setDefaultMetadataCache($this->_cache);
	}


	public function _initTwig()
	{
		$config = $this->getOption('twig');

		if (DEBUG) {
			unset($config['params']['cache']);
		}
		
		$viewRender = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRender->setView(new tools_Twig($config));
		$viewRender->setViewSuffix('twig');
		Zend_Controller_Action_HelperBroker::addHelper($viewRender);
	}


}
