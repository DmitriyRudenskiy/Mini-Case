<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_Tag extends Model_Base
{
	protected $_name = 'tagname';

	public function getId($name)
	{
		$select = $this->select()
			->from($this->_name, array('id'))
			->where('title="'.$name.'"');
		
		$result = $this->fetchRow($select);
		
		return (int)$result['id'];
	}
	
	protected function _getFilter()
	{
		return array(
			'is_visible'=> array(new Zend_Filter_Boolean()),
			'title' => array('StringTrim', 'StripTags'),
			'alias' => array('StringTrim', 'StripTags'),
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
				array('*'))
			->group('a.id')
			->order('a.id')
			->joinleft(
				array('c' => PREFIX . 'tagonpage'),
				'a.id = c.tag_id',
				array('COUNT(c.tag_id) as count')
			)
			->setIntegrityCheck(false);
	
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		return $adapter;
	}
	
	public function getTags($pageId)
    {
        $tagonpage = new Model_TagOnPage();
        $select = $this->select()
            ->from(array('a' => $this->_name), array('title'))
            ->join(
            	array('b' => PREFIX . 'tagonpage'),
            	'tag_id = id && page_id='.$pageId,
            	array())
        	;
    	
    	$result = $this->fetchAll($select);

    	if (is_object($result)) {
    	    $listTags = array();
    	    $data = $result->toArray();
    	    
    	    $x = sizeof($result);
    	    for ($i = 0; $i < $x; $i++)
    	        $listTags[] = $data[$i]['title'];
    	    
    	    return implode(', ', $listTags); 	    
    	}
    	
    	return '';
    }
    
    public function newTag($name)
    {
    	$alias = $this->translit($name);
    	$this->insert(array('title' => $name, 'alias' => $alias));
    	$tegId = $this->getId($name);
    	
    	return (int)$tegId;
    }
    
    protected function _clearData($post)
    {
    	$pageId = $post['id'];
    	$words = array_unique(explode(',', $post['tag']));
    	
    	$newGroupId = array();
    	
    	
    	
    	if (is_array($words) && !empty($words)) {
    		$x = sizeof($words);
    		for ($i = 0; $i < $x; $i++) {
    			
    			$oneWord = trim(strtolower($words[$i]));
    			
    			if ($oneWord != '') {
    				$tagId = $this->getId($oneWord);
    				 
    				if ((int)$tagId < 1)
    					$tagId = $this->newTag($oneWord);
    				 
    				$newGroupId[] = $tagId;
    				
    			}
	    	}
    	}
    	
    	return $newGroupId;
    }

    /*
    public function add($post)
    {
    	return $this->_clearData($post);
    }

    public function edit($post)
    {
    	return $this->_clearData($post);
    }
    */
}

/* End of file admin/models/Tag.php */