<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

abstract class Controller_Base extends Zend_Controller_Action
{
	protected $_model;
	protected $_form;
	
	/**
	 * Загрузка моделей и форм
	 */
	public function init()
	{
	    $nameClass = $this->_setNames();
	    
	    if (!empty($nameClass['_model'])) {
	    	$this->_model = new $nameClass['_model']();
	    }
	    
	    if (!empty($nameClass['_form'])) {
	    	$this->_form = new $nameClass['_form']();
	    }
	    
	    $this->_initMessageBox();
	}
	
	protected function _initMessageBox()
	{
	    $this->view->errors = $this->_helper->FlashMessenger
	    	->setNamespace('error')
	    	->getMessages();
	    
	    $success = $this->_helper->FlashMessenger
	    	->setNamespace('success')
	    	->getMessages();
	    
	    if(!empty($success)) {
	    	$this->view->success = $success[0];
	    }
	}
	
	public function preDispatch ()
	{
		$this->_checkAuth();
		
		if (is_object($this->_form)) {
		    $this->_setForm();
		}
	}

	public function postDispatch()
	{
		$this->view->base_url = 'http://'.$_SERVER['HTTP_HOST'] . '/admin/';
		
		$controller = $this->getRequest()->getControllerName();
		$action = $this->getRequest()->getActionName();

		$this->view->controller = $controller;
		$this->view->action = $action;
		
		//$this->_getBreadcrumb($controller, $action);
	}
	
	
	protected function _setNames()
	{
		
	}
	
	protected function _getErorrsForm()
	{

	}
	
	protected function _setForm()
	{
	
	}

	protected function _checkAuth()
	{
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_forward('index', 'auth');
			return;
		} else if (Zend_Auth::getInstance()->getIdentity()->session_ip != $_SERVER['REMOTE_ADDR']) {
			die("текущий IP-адрес не совпадает с IP сессии");
		}

 		$acl = new Acl_Base();
		
		$access = $acl->isAllowed(
			Zend_Auth::getInstance()->getIdentity()->role,
			$this->getRequest()->getControllerName(),
			$this->getRequest()->getActionName()	
		);
		
		if ($access != true) {
			$this->_forward('access', 'error');
			return;
		}
		
		$this->view->role = Zend_Auth::getInstance()->getIdentity()->role;
	}

	protected function _postEdit(& $data, $marker)
	{
		
	}
	
	/**
	 * Логирование действий
	 *
	 * @param unknown_type $id
	 */
	public function setLog($id)
	{
		$user = Zend_Registry::get('user');
	
		$model = new model_Log();
		$model->addLog(
				$user['id'],
				ip2long($_SERVER['REMOTE_ADDR']),
				$this->getRequest()->getControllerName(),
				$this->getRequest()->getActionName(),
				$id
		);
	}
	
	protected function _getPost($marker)
	{
		$data = $this->getRequest()->getPost();

		if ($this->_form->isValid($data)) {
			$this->_model->$marker($data);
			
			// log action user
			//$this->setLog($data['id']);
			
			// load image
			$this->_postEdit(& $data, $marker);
			
            $this->_helper->FlashMessenger
	            ->setNamespace('success')
	            ->addMessage(_('Запись обновлена.'));
			//$this->_helper->redirector('index');
		} else {
			$this->_form->populate($data);
		}
	}
	
	/**
	 * Список
	 */
	public function indexAction()
	{
		$this->view->group = $this->_model->fetchAll();
	}
	
	/**
	 * Добавляем запись
	 */
	public function addAction()
	{
		$this->view->form = $this->_form;
	
		if ($this->getRequest()->isPost()) {
			$this->_getPost('add');
		}
	}
	
	/**
	 * Редактируем запись
	 */
	public function editAction()
	{
		$this->view->form = $this->_form;
	
		if ($this->getRequest()->isPost()) {
			$this->_getPost('edit');
		} else {
			$id = (int)$this->getRequest()->getParam('id');
	
			if ($id > 0){
				$this->_form->populate($this->_model->getSingle($id));
			}
		}
	}
	
	/**
	 * Удаляем запись
	 */
	public function deleteAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		
		$id = (int)$this->getRequest()->getParam('id', 0);
		
		if ($id > 0){
			// log action user
			//$this->setLog($id);
			
			if ($this->_model->remove($id)) {
				$this->_endController('success', 'Delete record');
			}
		}
	}
	
	/**
	 * Показываем или прячем
	 */
	public function hideAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		
		$id = (int)$this->getRequest()->getParam('id', 0);
			
		if ($id > 0){
			$this->_model->update(array('is_visible' => 1), 'id ='.$id);
			$this->setLog($id);
			
			$this->_endController('success', 'Show/hide record');
		}
	}

	/**
	 * 
	 * @param unknown $controller
	 * @param unknown $action
	 */
	/*
	protected function _getBreadcrumb($controller, $action)
	{
		$pages['index']['index'] = array(
			'title' => 'Главная',
			'url' => '/admin'		
		);
		
		$pages['category']['index'] = array(
				'title' => 'Менеджер рубрик',
				'url' => '/admin/page'
		);
		
		$pages['category']['edit'] = array(
				'title' => 'Редактировать рубрику',
				'url' => ''
		);
		
		$pages['category']['add'] = array(
				'title' => 'Добавить рубрику',
				'url' => ''
		);
		
		$pages['page']['index'] = array(
				'title' => 'Менеджер страниц',
				'url' => '/admin/page'
		);
		
		$pages['page']['edit'] = array(
				'title' => 'Редактировать страницу',
				'url' => ''
		);
		
		$pages['page']['add'] = array(
				'title' => 'Добавить страницу',
				'url' => ''
		);
		
		$pages['image']['index'] = array(
				'title' => 'Менеджер страниц',
				'url' => '/admin/page'
		);
		
		$pages['image']['edit'] = array(
				'title' => 'Редактировать страницу',
				'url' => ''
		);
		
		$pages['image']['add'] = array(
				'title' => 'Добавить страницу',
				'url' => ''
		);
		
		$pages['menu']['index'] = array(
				'title' => 'Менеджер меню',
				'url' => '/admin/page'
		);
		
		$pages['menu']['edit'] = array(
				'title' => 'Редактировать меню',
				'url' => ''
		);
		
		$pages['menu']['add'] = array(
				'title' => 'Создать меню',
				'url' => ''
		);
		
		$pages['user']['index'] = array(
				'title' => 'Менеджер пользователей',
				'url' => '/admin/user'
		);
		
		$pages['user']['edit'] = array(
				'title' => 'Профиль',
				'url' => ''
		);
		
		$pages['user']['add'] = array(
				'title' => 'Добавить нового пользователя',
				'url' => ''
		);
		
		
		//Меню «111» успешно создано.
		
		$this->view->title = $pages[$controller][$action]['title'];
	}
	*/
}

/* End of file admin/controllers/BackedController.php */
