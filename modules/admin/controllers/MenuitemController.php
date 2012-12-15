<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class MenuitemController extends Controller_Base
{
    protected function _setNames()
    {
        return array(
        	'_model' => 'Model_MenuItem',
        	'_form' => 'Form_Menuitem'
		);
    }
	
	protected function _setForm()
	{
		$id = (int)$this->getRequest()->getParam('number');
		
		// self
        $data = $this->_model->getGroupItem($id);
        $this->_form->getElement('parent_id')
        	->setMultiOptions($this->_getItemsForSelectParent($data));

        // parent
        $model = new Model_Menu();
        $data = $model->fetchAll();

        if (is_object($data)) {
            $items = $data->toArray();
            $options = array();
            foreach ($items as $value) {
                $options[(int)$value['id']] = $value['title'];
            }

            if (!empty($options)) {
                $this->_form->getElement('menu_id')
                	->setMultiOptions($options);
            }
        }

	}

    public function indexAction()
    {
        $id = (int)$this->getRequest()->getParam('category');
        $data = $this->_model->getGroupItem($id);

        if ($data == 0) {
            $this->view->group = 0;
            return;
        }
			
		$menu = $this->_getHeir($data, sizeof($data), $parentId = 0);
        $this->view->group = $menu;
    }

    public function addAction()
    {
    	$id = (int)$this->getRequest()->getParam('id', 0);
		
        if ($this->getRequest()->isPost()) {
            $this->_getPost('add');
        }

        $id = (int)$tmp[0];
        $controller = $tmp[1];

        if ($id > 0 && $controller == 'category') {
            $model = new models_Category();
            $data = $model->getDataForMenu($id);
			
			var_dump($data);
			
			$post['link'] = $data['link'];
            $post['label'] = $data['name'];
        }

        if ($id > 0 && $controller == 'page') {
            $model = new models_Page();
            $data = $model->getDataForMenu($id);
            $post['link'] = $data['link'] . '.html';
            $post['label'] = $data['title'];
        }

        $this->_form->populate($post);
        $this->view->form = $this->_form;

    }
    
    public function categoryAction()
    {
    	if ($this->getRequest()->isPost()) {
    		$this->_getPost('add');
    	}
    	
    	$id = (int)$this->getRequest()->getParam('id', 0);
    	
    	$model = new Model_Category();
    	$data = $model->getDataForMenu($id);
    			
    	$post['link'] = $data['link'];
    	$post['label'] = $data['name'];
    
    	$this->_form->populate($post);
    	$this->view->form = $this->_form;
    
    }
    
    public function pageAction()
    {
    	$id = (int)$this->getRequest()->getParam('id', 0);

    	$model = new Model_Page();
    	$data = $model->getDataForMenu($id);
    	$post['link'] = $data['link'] . '.html';
    	$post['label'] = $data['title'];
    
    	$this->_form->populate($post);
    	$this->view->form = $this->_form;
    
    }
    
    public function tagAction()
    {
    	$id = (int)$this->getRequest()->getParam('id', 0);
    
    	$model = new Model_Page();
    	$data = $model->getDataForMenu($id);
    	$post['link'] = $data['link'] . '.html';
    	$post['label'] = $data['title'];
    
    	$this->_form->populate($post);
    	$this->view->form = $this->_form;
    
    }

    protected function _getHeir(&$arr, $x, $parentId = 0)
    {
        $data = array();

        for ($i = 0; $i < $x; $i++) {
            if ($arr[$i]['parent_id'] == $parentId) {
                $data[] = array(
                	'id' => $arr[$i]['id'],
                	'parent_id' => $arr[$i]['parent_id'],
                	'is_visible' => $arr[$i]['is_visible'],
                	'position' => $arr[$i]['position'],
                	'label' => $arr[$i]['label'],
                	'link' => $arr[$i]['link'],
                	'submenu' => $this->_getHeir($arr, $x, $arr[$i]['id']));
            }
        }

        if (empty($data))
            return 0;

        return $data;
    }

    /**
     *  Options fo select parent_id
     */
    protected function _getItemsForSelectParent(&$data)
    {
        $listCategory = array();

        $x = sizeof($data);
        for ($i = 0; $i < $x; $i++) {
            $listCategory[$data[$i]['id']] = $data[$i]['label'];
        }

        $listCategory[0] = $this->_language->firstItem;
        ksort($listCategory);
        return $listCategory;
    }
}

/* End of file admin/controllers/MenuitemController.php */
