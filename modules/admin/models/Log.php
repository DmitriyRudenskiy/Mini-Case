<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_Log extends Model_Base
{
    protected $_name = 'log';
	
	protected $_controller = array();
    
    protected $_action = array(
    	'add' => 0,
    	'edit' => 1,
    	'delete' => 2,
    	'crop' => 3,
    	'hide' => 4,
    	'show' => 5,
    );
    
	public  function init()
	{
		parent::init();
		
		$config = Zend_Registry::get('config');
		//$this->_controller = $config->controller->toArray();
	}
	
    public function attributeLabels()
    {
    	return array(
    		'user_id' => 0,
    		'user_ip' => 0,
    		'controller_id' => 0,
    		'action_id' => 0,
    		'resource_id' => 0
    	);
    }
	
	public function fetchPaginatorAdapter($filter)
	{
    	$select = $this->select()
	    	->from(
	    			array('a' => $this->_name),
	    			array('a.id', 'a.user_id', 'INET_NTOA(a.user_ip) as user_ip', 'a.controller_id', 'a.action_id', 'a.resource_id', 'a.created')
	    	)
	    	->order('a.created DESC')
	    	->joinLeft(
	    			array('b' => PREFIX.'user'),
	    			'a.user_id = b.id',
	    			array('b.login as user_login')
	    	)
	    	->setIntegrityCheck(false);
			
		//var_dump($select->__toString());
	    	
	    // >> begin filter
	    if (isset($filter['user_id']) && $filter['user_id'] > 0) {
	    	$select->where('a.user_id=?', (int)$filter['user_id']);
		}
		// << end filter

		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		return $adapter;
	}
    
    public function addLog($post)
    {
		foreach ($this->_controller as $key => $value) {
			if ($post['controller_id'] == $value['alias']) {
				$post['controller_id'] = $key;
				$post['action_id'] = $this->_action[$post['action_id']];
				
				$this->insert($post);
			}
		}
    }

}

/* End of file admin/models/Category.php */
