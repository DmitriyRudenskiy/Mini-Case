<?php

/**
 * @package		miniCase
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @version		0.91
 */

class Model_Page extends Model_Base
{
    protected $_name = 'page';

    protected function _getFilter()
    {
    	return array(
    		'is_visible'=> array(new Zend_Filter_Boolean()),
    		'page_id' => array('Int'),
    		'tag_id' => array('Int'),
    		'category_id' => array('Int'),
    		'link' => array('StringTrim', 'StripTags'),
    		'header' => array('StringTrim', 'StripTags'),
    		'title' => array('StringTrim', 'StripTags'),
    		'description' => array('StringTrim', 'StripTags'),
    		'keywords' => array('StringTrim', 'StripTags'),
    		'anons' => array('StringTrim', 'StripTags'),
    		'content' => array('StringTrim', 'StripTags'),
    		'changed' => array('StringTrim', 'StripTags')
    	);
    }
    
    /**
     * 
     * @param unknown $filter
     * @return Zend_Paginator_Adapter_DbTableSelect
     */
    public function fetchPaginatorAdapter($filter = array())
    {
    	$select = $this->select()
    		->from(
    			array('a' => $this->_name),
    			array('id', 'is_visible', 'link', 'title'))
    		->join(
    			array('c' => PREFIX . 'category'),
    			'a.category_id = c.id',
    			array('c.title as category', 'c.link as category_link')
    		)
    		->setIntegrityCheck(false);
    
    		
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	return $adapter;
    }

    public function getPage($url)
    {   
        if ($url == '') {
            return 0;
        }
        
    	$select = $this->select()
    		->from(
    		    $this->_name,
    			array('header', 'content', 'title', 'description', 'keywords')
    		)
    		->where('link="'.$url.'"')
    		->where('is_active=1');
            
       $result = $this->fetchRow($select);

       if(is_object($result)) {
            return $result->toArray();
        } 

        return 0;
    }
    
    /**
     * MenuitemController -> addAction()
     * 
     * @param unknown_type $id
     */
    public function getDataForMenu($id)
    {
    	if ($id < 1) {
    		return 0;
    	}
    	
    	$select = $this->select()
	    	->from($this->_name, array('title', 'link'))
	    	->where('id='.$id);
    	
    	$result = $this->fetchRow($select);
    	
    	if(is_object($result)) {
    		return $result->toArray();
    	}
    	 
    	return 0;
    }
    
    public function getLastId()
    {
    	$select = $this->select()
    	->from($this->_name, array('MAX(id)'));
    
    	$result = $this->fetchRow($select);
    	 
    	if(is_object($result))
    		return $result->toArray();
    }
    
    protected function _getUniqueLink($url, $id)
    {
    	if ($url == '') {
    		return false;
    	}
    
    	$select = $this->select()
    	->from($this->_name, 'id')
    	->where('link="'.$url.'"')
    	->where('id<>?', $id);
    	 
    	$result = $this->fetchRow($select);
    
    	if(is_object($result)) {
    		return false;
    	}
    	 
    	return true;
    }

    /**
     * (non-PHPdoc)
     * @see models_Base::_clearData()
     */
	protected function _clearData($post)
	{
		if (isset($post['title']) || $post['title'] == '')
			$post['title'] = $post['header'];
		
		if (isset($post['link']))
		    $post['link'] = tools_Text::translit(trim($post['link']));
		
		if (isset($post['link']) && $post['link'] == '')
			$post['link'] = tools_Text::translit(trim($post['header']));

			
        if (!$this->_getUniqueLink($post['link'], $post['id'])) {
            $post['link'] .= '_'.$post['id'];
        }
        
        if (isset($post['anons']) && $post['anons'] == '')
            $post['anons'] = strip_tags($post['content']);

		return parent::_clearData($post);
	}
}

/* End of file admin/models/Page.php */