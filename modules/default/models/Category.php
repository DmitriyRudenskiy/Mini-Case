<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_Category extends Model_Base
{
    protected $_name = 'category';
	
	public function getCategory($id)
    {
    	$select = $this->select()
    		->from($this->_name, array('name', 'link'))
    		->where('is_visible=1')
    		->where('id=?', $id);
			
    	$result = $this->fetchRow($select);
    	
    	if(is_object($result))
    	    return $result->toArray();
    }

    public function getIdCategory($url)
    {  	
    	$select = $this->select()
    		->from($this->_name, array('id', 'type', 'title'))
    		->where('is_visible=1')
    		->where('link=?', $url);
    	
    	$result = $this->fetchRow($select);
    	
    	if (is_object($result)) {
    	    return $result->toArray();
    	} 

    	return 0;
    }
}

/* End of file application/models/Category.php */
