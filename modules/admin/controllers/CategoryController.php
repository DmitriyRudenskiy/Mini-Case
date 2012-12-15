<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class CategoryController extends Controller_Base
{
	protected function _setNames()
	{
		return array(
			'_model' => 'Model_Category',
			'_form' => 'Form_Category'
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
	
	protected function _setForm()
	{
		$validator = new Zend_Validate_Db_NoRecordExists(PREFIX.'category', 'link');
		
	    $this->_form->getElement('link')->addValidator($validator);

	    
	    $this->_form->getElement('parent_id')
	    	->setMultiOptions($this->_model->getSelectItemsCategory());
	    
	    $this->_form->getElement('type')
	    	->setMultiOptions(array('Общая', 'Список', 'Галерея'));
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

/* End of file admin/controllers/CategoryController.php */
