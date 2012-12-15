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

    public function attributeLabels()
    {
    	return array(
    		'is_visible' => 0,
    		'existence' => 0,
    		'category_id' => 0,
    		'name' => 0,
    		'title' => 0,
    		'alt' => 0
    	);
    }
    
    /**
     *
     * @param unknown $filter
     * @return Zend_Paginator_Adapter_DbTableSelect
     */
    public function fetchPaginatorAdapter($filter = array())
    {
    	$select = $this->select();
    
    
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	return $adapter;
    }

    public function addImage($fileName)
    {
    	$this->insert(array('name' => $fileName));

    	$select = $this->select()
    		->from($this, array('id'))
    		->where('name="'.$fileName.'"');

    	$id = $this->fetchRow($select);

    	$id = (int)$id['id'];
    	$this->update(array('existence' => 1, 'name' => ''), 'id ='.$id);

    	return $id;
    }
}

/* End of file admin/models/Image.php */