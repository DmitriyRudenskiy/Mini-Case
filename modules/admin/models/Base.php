<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

abstract class Model_Base extends Zend_Db_Table_Abstract
{
	/**
	 * Добавляем префикс к названию таблиц
	 */
	protected function _setupTableName()
	{
		$this->_name = PREFIX . $this->_name;
	}
	
	/**
	 * Filter array for insert/update methods
	 * @var array
	 */
	protected function _getFilter()
	{

	}
	
	/**
	 * Validates and Filters array data
	 *
	 * @param array $data
	 * @return array Validation success
	 */
	protected function _setValid($data, $options = null)
	{
		$input = new Zend_Filter_Input(
			$this->_getFilter(),
			null,
			$data,
			$options
		);
		
		return array_intersect_key(
				$input->getEscaped(),
				$this->_getFilter()
			); 
	}
	
	/**
	 * 
	 * @param unknown $post
	 * @return number|unknown
	 */
	public function add($post = array())
	{
		if (!is_array($post) && empty($post)) {
			return 0;
		}
		
		$data = $this->_setValid($post);
		$result = $this->insert($data);
		
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $post
	 * @return number|unknown
	 */
	public function edit($post = array())
	{
		if (!is_array($post) && empty($post)) {
			return 0;
		}
		
		$data = $this->_setValid($post);
		$result = $this->update($data, 'id ='.$post['id']);
		
		return $result;
	}
	
	/**
	 * 
	 * @param number $id
	 */
	public function remove($id = 0)
	{
		if ($id < 1) {
			return 0;
		}
			
		$this->update(array('removed' => 1), 'id ='.$id);
	}
	
	/**
	 * 
	 * @param number $id
	 * @return number
	 */
	public function getSingle($id = 0)
	{
		if ($id < 1) {
			return 0;
		}
		
		$select = $this->select()
			->where('id=?', $id);
		
		$result = $this->fetchRow($select);
	
		if(is_object($result)) {
			return $result->toArray();
		}
		
		return 0;
			
	}
}

/* End of file admin/models/Base.php */
