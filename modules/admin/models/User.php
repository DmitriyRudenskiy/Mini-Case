<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_User extends Model_Base
{
	protected $_name = 'user';

	public function attributeLabels()
	{
		return array(
			'is_active' => 0,
			'first_name' => 0,
			'last_name' => 0,
			'email' => 0,
			'password' => 0,
			'last_access' => 0,
			'ip' => 0
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
		);
	
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		return $adapter;
	}

	public function getSingle($id)
	{
		$select = $this->select()
			->where('id=?', $id)
			->where('removed=0');
		
		$result = $this->fetchRow($select);
		
		if(is_object($result)) {
			return $result->toArray();
		}
		
		return 0;
	}
	
	public function getAllUsers()
	{
		$select = $this->select()
			->where('id<>1')
			->where('removed=0')
			->order('role');
	
		$result = $this->fetchAll($select);
	
		if(is_object($result)) {
			return $result->toArray();
		}
	
		return 0;
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
			
		$this->delete('id =' . $id);
	}

	protected function _clearData($post)
	{
		$post['login'] = base64_encode($post['login']);
		$post['email'] = base64_encode($post['email']);
		
		if (!empty($post['password'])) {
			$post['password'] = md5($post['password']);
		}

		return parent::_clearData($post);
	}
}

/* End of file admin/models/User.php */