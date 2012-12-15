<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_Page extends Model_Base
{
    protected $_name = 'page';

    public function getPage($url)
    {
    	$select = $this->select()
    		->from(
    			array('a' => $this->_name),
    			array('id', 'header', 'content', 'title', 'description', 'keywords')
			)
			->joinLeft(
				array('b' => $this->_prefix.'category'),
				'b.id = a.category_id',
				array('name', 'link')
				)
			->setIntegrityCheck(false)
    		->where('a.link="'.$url.'"')
    		->where('a.is_visible=?', 1);

    	$result = $this->fetchRow($select);
    	
    	if(is_object($result))
    	    return $result->toArray();
    }
    
    public function getPages()
    {
    	$select = $this->select()
    		->where('is_visible=?', 1)
    		->order('created DESC');
    
    	$result = $this->fetchAll($select);
    	 
    	if(is_object($result))
    		return $result->toArray();
    }
    
    
    public function fetchPaginatorAdapter($marker, $name)
    {
    	$config = Zend_Registry::get('config');
    
    	$select = $this->select();
    	
    	// category
    	if ($marker == 'category') {
    		$select->from($this->_name, array('id', 'link', 'header', 'anons'))
                ->where('is_visible=?', 1);
    		 
    		if($name != null)
    			$select->where('category_id=?', $name);
    	}

    	// tag
    	if ($marker == 'tag') {
    		$select->from(
    			array('a' => $this->_name),
    			array('id', 'link', 'header', 'anons')
    		)
    		->where('is_visible=1')
    		->join(array('b' => $this->_prefix.'tagname'), "b.alias='".$name."'", array())
    		->join(array('c' => $this->_prefix.'tagonpage'), 'a.id = c.page_id && b.id = tag_id ', array());
    	}
    	
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	return $adapter;
    }  
    
}

/* End of file application/models/Page.php */
