<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

abstract class Controller_Base extends Zend_Controller_Action
{
    protected $_cache;

    public function init()
    {
       $this->_cache = Zend_Registry::get('cache');
    }
    
    protected function _checkAuth()
    {
    	$auth = Zend_Auth::getInstance();
    	
    	$user =array();
    	
    	if ($auth->hasIdentity()) {
    		$user['first_name'] = $auth->getIdentity()->first_name;
    		$user['last_name'] = $auth->getIdentity()->last_name;
    		$user['role'] = strtolower($auth->getIdentity()->role);
    	} else {
    		$user['role'] =  'guest';
    	}
    	
    	$this->view->auth = $user;
    	
/* 		$controller = $this->getRequest()->getControllerName();
		$action = $this->getRequest()->getActionName();
		
		$acl = new controllers_Acl();
    	
    	if (!$acl->isAllowed($role, $controller, $action)) {
    		if ($role == 'guest') {
    			$request->setControllerName('user');
    			$request->setActionName('login');
    		} else {
    			$request->setControllerName('error');
    			$request->setActionName('noauth');
    		}
    	} */
    }
    
    public function preDispatch ()
    {
    	$this->_checkAuth();
    	$this->_login();
    }

    public function postDispatch()
    {
        $this->view->base_url = 'http://' . $_SERVER['HTTP_HOST'].'/';
        $this->view->controller = $this->getRequest()->getControllerName();
        $this->view->action = $this->getRequest()->getActionName();
        
        $this->view->breadcrumb = $this->_breadcrumb;
        $this->view->menu = $this->buildMenu();
    }
	
	protected function _getPaginator(& $model, $type, $id, $count, $page = 1)
    {
    	$adapter = $model->fetchPaginatorAdapter($type, $id);
    	 
    	$paginator = new Zend_Paginator($adapter);
    	$paginator->setItemCountPerPage($count);
    	$paginator->setCurrentPageNumber($page);
    	 
    	return $paginator;
    
    }

    public function buildMenu()
    {
        if ($this->_cache->load('menu')) {
            return $this->_cache->load('menu');
        } else {
        	$model = new Model_Menu();
        	$data = $model->getMenu(1);
        	$this->_cache->save($data, 'menu');
        }

        return $data;
    }
    
    protected function _login()
    {
    	$this->view->form = new Form_Login();
    }
}

/* End of file application/controllers/FrontedController.php */
