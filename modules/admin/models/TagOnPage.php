<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_TagOnPage extends Model_Base
{
    protected $_name = 'tagonpage';
    public $pageId;
    
    protected function _getFilter()
    {
    	return array(
    		'is_visible'=> array(new Zend_Filter_Boolean()),
    		'page_id' => array('Int'),
    		'tag_id' => array('Int'),
    	);
    }
    
    public function getOldGroupID()
    {      
    	$select = $this->select()
	    	->from($this->_name, array('tag_id'))
    	    ->where('page_id=?', $this->pageId);  	
    	
    	$result = $this->fetchAll($select);
    	
    	if (is_object($result)) {
    	    $newGroupId = array();
    		$data = $result->toArray();
    			
    		$x = sizeof($result);
    		for ($i = 0; $i < $x; $i++) {
    		    $newGroupId[] = (int)$data[$i]['tag_id']; 		    
    		}
    	    	    
    		return $newGroupId;
    	}
    	
    	return;
    }
    
    public function newTagOnPage($tagsId)
    {
    	$x = sizeof($tagsId);
    	for ($i = 0; $i < $x; $i++) {
    		$this->insert(
    		    array(
    		    	'page_id' => $this->pageId,
    		    	'tag_id' => $tagsId[$i]
    		    )
    		);
    	} 	
    }
    
    public function delTagOnPage($tagsId, $pageId)
    {
    	$x = sizeof($tagsId);
    	for ($i = 0; $i < $x; $i++) {
    		$this->delete(
    		    array(
    		    	'page_id = '. $this->pageId,
    		    	'tag_id = '. $tagsId[$i]
    		    )
    		);
    	}    	 
    }
    
    public function add($post)
    {
    	$this->newTagOnPage($post);
    }
    
    public function edit($post)
    {
    	// tag for delete
    	$oldGroupId = $this->getOldGroupID();
    	$listTags = array_values(array_diff($oldGroupId, $post));
    	
    	if (!empty($listTags)) {
    		$this->delTagOnPage($listTags);
    	}
    		
    	// find new tat go insert
    	$listTags = array_values(array_diff($post, $oldGroupId));
    	
    	if (!empty($listTags)) {
    		$this->newTagOnPage($listTags);
    	}
    		
    }
}

/* End of file admin/models/TagOnPage.php */
