<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_Image extends Model_Base
{
	protected $_name = 'image';
    
    public function fetchPaginatorAdapter($marker, $name)
    {
    	$select = $this->select()
	    	->where('is_visible=1')
	    	->order('id');

    	if($name != null)
    		$select->where('category_id="'.$name.'"');
    	
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	return $adapter;
    }
}

/* End of file application/model/Image.php */
