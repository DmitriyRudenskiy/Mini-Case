<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class TagController extends controllers_FrontedController
{
    public function indexAction()
    {
        $url = $this->_getParam('url');
        $number = (int)$this->_getParam('number');
		
		$count = 3;

        $model = new models_Page();
		$paginator = $this->_getPaginator($model, 'tag', $url, $count, $number);
		
		$item = array(
			'title' => $url,
			'type' => '1',
			'noseo' => '1'
		);

        $this->view->list = $paginator->getItemsByPage($number);
        $this->view->navi = $paginator->getPages();
		$this->view->item = $item;

        $this->view->link = 'tag/' . $url;
        $this->view->number = $number;
    }

    public function getTags($id)
    {
        $model = new models_Tag();
        $this->view->tags = $model->getTags($id);
    }
}

/* End of file application/controllers/TagController.php */
