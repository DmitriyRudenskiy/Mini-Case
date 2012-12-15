<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class UserController extends Controller_Base
{
	protected function _setNames()
	{
		return array(
			'_model' => 'Model_User',
			'_form' => 'Form_User'
		);
	}
	
	public function indexAction()
	{
		$number = (int)$this->getRequest()->getParam('id', 1);
		
		$config = Zend_Registry::get('config');
		
		$adapter = $this->_model->fetchPaginatorAdapter($this->_createForm());
		
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($config['count']['pages']);
		$paginator->setCurrentPageNumber($number);
		
		$this->view->group = $paginator->getCurrentItems()->toArray();
		$this->view->navi = $paginator->getPages();
	}
	
	public function showAction()
	{
		$id = (int)$this->getRequest()->getParam('id');
			
		if ($id > 0){
			$this->_model->update(array('is_active' => 1), 'id ='.$id);
		}
	
		$this->_helper->getHelper('Redirector')
		->gotoUrl($_SERVER['HTTP_REFERER']);
	}
	
	public function hideAction()
	{
		$id = (int)$this->getRequest()->getParam('id');
			
		if ($id > 0){
			$this->_model->update(array('is_active' => 0), 'id ='.$id);
		}
	
		$this->_helper->getHelper('Redirector')
		->gotoUrl($_SERVER['HTTP_REFERER']);
	}
	
	protected function _createForm()
	{
		if (!empty($_SERVER['QUERY_STRING'])) {
			$this->view->query_string = '?'.$_SERVER['QUERY_STRING'];
		}
	
		$form = new Form_PageFilter();
	
		$filter['status'] = (int)$this->getRequest()->getParam('status', 2);
		$filter['category'] = (int)$this->getRequest()->getParam('category', 0);
		$filter['link'] = $this->getRequest()->getParam('link', '');
		$filter['title'] = $this->getRequest()->getParam('title', '');
	
		$form->populate($filter);
	
		$this->view->form = $form;
	
		return $filter;
	}
}

/* End of file admin/controllers/UserController.php */
