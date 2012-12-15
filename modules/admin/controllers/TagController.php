<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class TagController extends Controller_Base
{
	protected function _setNames()
	{
		return array(
			'_model' => 'Model_Tag',
			'_form' => 'Form_Tag'
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
	
	protected function _createForm()
	{
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
