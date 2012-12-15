<?php

/**
 * @package		miniCase
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @version		0.91
 */

class Model_Tag extends Model_Base
{
	protected $_name = 'tagname';

	public function getTags($id)
	{ 
		$select = $this->select()
			->from(array('a' => $this->_name), array('title', 'alias'))
			->join(
				array('c' => PREFIX . 'tagonpage'),
				'tag_id = id && page_id='.(int)$id,
				array()
			);
			
		$result = $this->fetchAll($select);
		
		if(is_object($result)) {
    	    return $result->toArray();
		}
    }

}

/* End of file application/model/Tag.php */
