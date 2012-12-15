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

    public function attributeLabels()
    {
    	return array(
    		'is_visible' => 0,
        	'parent_id' => 0,
        	'type' => 0,
        	'image_id' => 0,
        	'link' => 0,
        	'name' => 0,   	
        	'title' => 0,
        	'description' => 0,
        	'keywords' => 0
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
    		array('*')
    	)
    	->joinleft(
    		array('c' => $this->_name),
    		'a.parent_id = c.id',
    		array('c.title as parent_category', 'c.link as parent_category_link')
    	)
    	->setIntegrityCheck(false);
    
    
    	$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    	return $adapter;
    }
    
    public function getIdCategory($url = 'home')
    {
    	$select = $this->select()
    		->from($this->_name, array('id', 'type', 'title'))
    		->where('link="'.$url.'"');

    	$result = $this->fetchRow($select)->toArray();

    	if(is_object($result))
		    return $result->toArray();
    }

    /*
    public function getGroupCategory($type = null)
    {
    	$select = $this->select()->from($this->_name, array('id', 'name'));

    	if($type != null)
    		$select->where('type=?', $type);
    	
    	$result = $this->fetchAll($select);
    	
    	if(is_object($result))
    	    return $result->toArray();
    	
    	return 0;

    }
    */
    
    /**
     * MenuitemController -> addAction()
     *
     * @param unknown_type $id
     */
    public function getDataForMenu($id)
    {
    	$select = $this->select()
    	->from($this->getTableName(), array('name', 'link'))
    	->where('id=?', $id);
    	 
    	$result = $this->fetchRow($select);
    	 
    	if(is_object($result)) {
    		return $result->toArray();
    	}
    
    	return 0;
    }
    
    protected function _clearData($post)
    {
    	if (isset($post['title']) || $post['title'] == null)
    	$post['title'] = $post['name'];
		
		if (isset($post['link']))
		    $post['link'] = tools_Text::translit(trim($post['link']));
		
		if (isset($post['link']) && $post['link'] == '')
			$post['link'] = tools_Text::translit(trim($post['name']));
    
    	return parent::_clearData($post);
    }
    
    /**
     * for add or edit CategoryController, PageController, ImageController
     */
    public function getSelectItemsCategory($type = 0)
    {
    	
    	$select = $this->select()
    		->from($this->_name, array('id', 'name'))
    		->order('id');
    	
    	if ($type > 0) {
    		$select->where('type=?', $type);
    	}
    	 
    	$result = $this->fetchAll($select);
    	 
    	if(is_object($result)) {
    		$options[0] = 'Родительская категория';
			
			foreach ($result as $key => $value) {
				$options[(int)$value->id] = $value->name;
			}
		
    		return $options;
    	} 
    }

}

/* End of file admin/models/Category.php */