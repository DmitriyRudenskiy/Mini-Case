<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class PageController extends Controller_Base
{
	protected function _setNames()
	{
		return array(
				'_model' => 'Model_Page',
				'_form' => 'Form_Page'
		);
	}

	protected function _setForm()
	{
	    $pageId = (int)$this->getRequest()->getParam('id');
	    
	    if ($pageId > 0) {
	    	$tags = new Model_Tag();
	    	$this->_form->getElement('tag')->setValue($tags->getTags($pageId));
	    }
	    
	    $model = new Model_Category();
	     
	    $this->_form->getElement('category_id')
	    	->setMultiOptions($model->getSelectItemsCategory(1));
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
    
    protected function _setTag(& $data, $marker)
    {
        $id = (int)$data['id'];
        
        if ($marker == 'edit' && $id > 0) {
            $pageId = $id;
        } else {
            $tmp = $this->_model->getLastId();
            $pageId = $tmp['MAX(id)'];
        }
        
        $tagModel = new Model_Tag();
        $listTags = $tagModel->$marker($data);
        
        // 
        $tagOnPage = new Model_TagOnPage();
        $tagOnPage->pageId = $pageId;
        $tagOnPage->$marker($listTags);
    }
	
	protected function _getPost($marker)
	{
		$this->_formData = $this->getRequest()->getPost();

		if ($this->_form->isValid($this->_formData)) {
		    	
			// page
			$this->_model->$marker($this->_formData);
			
			// tag
            $this->_setTag($this->_formData, $marker);

            $this->_helper->FlashMessenger
	            ->setNamespace('success')
	            ->addMessage(_('Страница обновлена.'));
			//$this->_helper->redirector('index');
		} else {
			$this->_form->populate($this->_formData);
		}
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

/* End of file admin/controllers/PageController.php */
