<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_Menu extends Model_Base
{
	protected $_name = 'menu';
	protected $_dependentTables = array('models_MenuItem');
	protected $_referenceMap = array(
			'Menu' => array(
				'columns' => array('parent_id'),
				'refTableClass'=> 'Model_Menu',
				'refColumns' => array('id'),
				'onDelete' => self::CASCADE
			)
		);
	
	public function attributeLabels()
	{
		return array(
			'place' => 0,
			'parent_id' => 0,
			'title' => 0,
			'url' => 0
		);
	}
	
	public function getItems()
	{
		$select = $this->select()->order('parent_id')->order('place');
		$data = $this->fetchAll($select);
		
		if (is_object($data)) {
			return $data->toArray();
		}
		
		return 0;
	}
}

/* End of file admin/models/Menu.php */