<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class controllers_Acl extends Zend_Acl
{
    public function  __construct()
    {
    	$this->addRole(new Zend_Acl_Role('guest'));
    	$this->addRole(new Zend_Acl_Role('user'), 'guest');
    	$this->addRole(new Zend_Acl_Role('admin'), 'user');

    	$this->add(new Zend_Acl_Resource('index'));
    	$this->add(new Zend_Acl_Resource('error'));
    	$this->add(new Zend_Acl_Resource('page'));
    	$this->add(new Zend_Acl_Resource('menu'));
    	$this->add(new Zend_Acl_Resource('menuitem'));
    	$this->add(new Zend_Acl_Resource('user'));
    	$this->add(new Zend_Acl_Resource('search'));

		$this->allow(null, array('index', 'error'));

		$this->allow('guest', 'search', array('index', 'search'));
		$this->allow('guest', 'page', array('index', 'open'));
		$this->allow('guest', 'menu', array('render'));
		$this->allow('guest', 'user', array('login'));

		$this->allow('user', 'page', array('list', 'create', 'edit', 'delete'));

		$this->allow('admin', null);
    	
	}
}

/* End of file application/controllers/Acl.php */
