<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Acl_Base extends Zend_Acl
{
    public function  __construct()
    {
    	// add the roles
    	$this->addRole(new Zend_Acl_Role('admin'));
    	$this->addRole(new Zend_Acl_Role('su'), 'admin');
    	
    	// add the resources
    	$this->add(new Zend_Acl_Resource('index'));
    	$this->add(new Zend_Acl_Resource('error'));
    	$this->add(new Zend_Acl_Resource('page'));
    	$this->add(new Zend_Acl_Resource('category'));
    	$this->add(new Zend_Acl_Resource('image'));
    	$this->add(new Zend_Acl_Resource('menu'));
    	$this->add(new Zend_Acl_Resource('menuitem'));
    	$this->add(new Zend_Acl_Resource('tag'));
    	$this->add(new Zend_Acl_Resource('log'));
    	$this->add(new Zend_Acl_Resource('user'));
    	 
		// set up the access rules
		$this->allow(null, array('index', 'error'));
		
		// administrators can do anything
		$this->allow('admin', 'index');
		$this->allow('admin', 'page');
		$this->allow('admin', 'category');
		$this->allow('admin', 'image');
		$this->allow('admin', 'menu');
		$this->allow('admin', 'menuitem');

		// su can do anything
		$this->allow('su', null);
	}
}

/* End of file admin/controllers/Acl.php */
