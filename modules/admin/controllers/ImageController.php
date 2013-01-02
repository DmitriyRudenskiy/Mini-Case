<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class ImageController extends Controller_Base
{
	protected function _setNames()
	{
		return array(
				'_model' => 'Model_Image',
				'_form' => 'Form_Image'
		);
	}
	
	protected function _setForm()
	{
		$model = new Model_Category();
	
		$this->_form->getElement('category_id')
			->setMultiOptions($model->getSelectItemsCategory(2));
	}
	
	protected function _endController($space, $text)
	{
		$this->_helper->FlashMessenger
			->setNamespace($space)
			->addMessage($text);
		
		$this->_helper->getHelper('Redirector')
			->gotoUrl($_SERVER['HTTP_REFERER']);
	}
	
	public function indexAction()
	{
		$number = (int)$this->getRequest()->getParam('id', 1);
		
		$filter = null;
		
		/*
		$category = (int)$this->getRequest()->getParam('category');
		
		$filter  = array(
				//'category_id' => $categoryId,
				//'category_id' => 0,
				//'is_active' => 0
		);
		$this->view->category = '/'.$category;
		*/

		$config = Zend_Registry::get('config');
		
		$adapter = $this->_model->fetchPaginatorAdapter($filter, $number);
		
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($config['count']['images']);
		$paginator->setCurrentPageNumber($number);
	
		$this->view->group = $paginator->getItemsByPage($number);
		$this->view->navi = $paginator->getPages();
	}

	public function addAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		
		if ($this->_request->isPost()) {
			$upload = new Zend_File_Transfer();
			
			if ($upload->receive()) {
			    $source = $upload->getFileName();
			    
			    include_once 'system/Image.php';
			    $image = new system_Image($source);
			    
			    //if (file_exists($source) && $image->isImage()) {
			    if (file_exists($source)) {
			    	
			    	$config = Zend_Registry::get('config');
			    	$dir = APPLICATION_PATH . $config['image']['upload'];

			    	// get id new image
			        $newName = $this->_model->addImage($source);
			        
			        // save original image
			        if (!mkdir($dir.$newName, 0777)) {
			        	$this->_endController('error', 'Not create folder');
			        	return 0;
			        }
			        
			        if (!copy($source, $dir.$newName.'/image.'.$image->extension)) {
			        	$this->_endController('error', 'Not copy files');
			        	return 0;
			        }
			        
			        $this->_createItemGallery($image, $newName);
				}
			}
			
			$this->_endController('success', 'Post created!');
		}
	}

	public function editAction()
	{
		if ($this->getRequest()->isPost()) {
			$this->_getPost('edit');
			return;
		}

		$id = (int) $this->_getParam('id');

		if ($id > 0) {
			$this->_form->populate($this->_model->getSingle($id));
			
			$this->view->image = $id;
			$this->view->form = $this->_form;
			return;
		}
		
		$this->_helper->redirector('index');
	}

	public function replaceAction()
	{
		if ($this->_request->isPost()) {
			
			$upload = new Zend_File_Transfer();
			$upload->receive();
			
			$this->_createItemGallery(
				$upload->getFileName(),
				(int) $this->_getParam('id'),
				$this->_request->getPost('type')
			);		
		}

		$this->_helper->getHelper('Redirector')
			->gotoUrl($_SERVER['HTTP_REFERER']);
	}
	
	public function cropAction()
	{
		$id = (int) $this->_getParam('id');
		
		if ($id < 1) {
			$this->_helper->redirector('index');
			return;
		}
		
        $config = Zend_Registry::get('config');
        $formatWidth = 500;
        
		if ($this->_request->isPost()) {
			$source = $_SERVER['DOCUMENT_ROOT'] . '/public/original/'.$id.'/image.jpg';
			$sourceNewImage = $_SERVER['DOCUMENT_ROOT'] . $config->galleryDir . $id . '_m.jpg';

            $image = new tools_Image($source);
            $scale = $image->info['width'] / $formatWidth;

            $topX = (int) ($this->_request->getPost('x1') * $scale); 
            $topY = (int) ($this->_request->getPost('y1') * $scale); 
            $bottomX = (int) ($this->_request->getPost('x2') * $scale); 
            $bottomY = (int) ($this->_request->getPost('y2') * $scale); 
          
            $image->crop($topX, $topY, $bottomX, $bottomY, $config->smallSize->width, $config->smallSize->height);
            $image->save($sourceNewImage, 80);
            
            $this->_helper->redirector('index');
        }
		
		$this->view->image = $id;
        $this->view->formatWidth = $formatWidth;
		$this->view->width = $config->smallSize->width;
		$this->view->height = $config->smallSize->height;
		
	}

	protected function _createItemGallery($image, $newName, $marker = null)
	{
		$config = Zend_Registry::get('config');
		$name = APPLICATION_PATH.$config['image']['gallery'].$newName;
		
		if ($marker != 'm') {
			$image->resize(
				$config['image']['big']['width'],
				$config['image']['big']['height']
			);
			
			$image->save($name . '_b.jpg', 100);
		}
		
		if ($marker != 'b') {
			$image->resize(
				$config['image']['small']['width'],
				$config['image']['small']['height']
			);
			
			$image->save($name . '_m.jpg', 80);
		}
	}

}

/* End of file admin/controllers/ImageController.php */
