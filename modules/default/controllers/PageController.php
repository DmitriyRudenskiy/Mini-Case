<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class PageController extends Controller_Base
{
	
    public function viewAction()
    {
        $url = $this->_getParam('url');

        if ($this->_cache->load($url)) {
            $data = $this->_cache->load($url);
        } else {
            $data = array();
			
			$page = new Model_Page();
            $data['page'] = $page->getPage($url);
			
			$category = array(
				'name' =>  $data['page']['name'],
				'link' =>  $data['page']['link']
			);
			
			$data['page']['category'] = $category;
			
			$tags = new Model_Tag();
            $data['tags'] = $tags->getTags($data['page']['id']);

            // start plugin
            //$plugin = new plugins_Image();
            //$data['page']['content'] = $plugin->find($data['page']['content']);

            $this->_cache->save($data, $url, array('page'));
        }

        $this->view->item = $data['page'];
        $this->view->tags = $data['tags'];
    }

}

/* End of file application/controllers/PageController.php */
