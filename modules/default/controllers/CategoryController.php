<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class CategoryController extends Controller_Base
{
	public function listAction()
	{
		$url = $this->_getParam('url', 'home');
		$number = (int)$this->_getParam('number', 1);

		$modelCategory = new Model_Category();
		$category = $modelCategory->getIdCategory($url);

		if (empty($category)) {
			throw new Zend_Controller_Action_Exception('Not found page', 404);
		}
		
		$config = Zend_Registry::get('config');

		if ($category['type'] == '1') {
			$count = $config['count']['pages'];
		} else {
			$count = $config['countImages'];
		}

		$model = $this->_getTypeCategory((int)$category['type']);
		$paginator = $this->_getPaginator($model, 'category', $category['id'], 3, $number);

		$this->view->list = $paginator->getItemsByPage($number);
		$this->view->navi = $paginator->getPages();
		$this->view->item = $category;
		$this->view->link = $url;
		$this->view->number = $number;
	}

    protected function _getTypeCategory($type)
    {
        switch ($type) {
            case 2 :
                $nameModel = 'Model_Image';
                break;
            default :
                $nameModel = 'Model_Page';
        }

        return new $nameModel();
    }

}

/* End of file application/controllers/CategoryController.php */
