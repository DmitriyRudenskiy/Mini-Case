<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_Auth extends Model_Base
{
	protected $_name = 'user';

	public function getAuthAdapter($login, $password)
	{
		$authAdapter = new Zend_Auth_Adapter_DbTable(
			$this->getAdapter(),
			$this->_name,
			'login',
			'password'
		);

		$authAdapter->setIdentity(base64_encode($login))
			->setCredential($password)
			->setCredentialTreatment('MD5(?)');

		return $authAdapter;
	}
	
	public function lastVizit($login)
	{
		$post = array();

		$post['last_visit'] = date('Y-m-d H:i:s');
		$post['ip'] = $_SERVER['REMOTE_ADDR'];

		$this->update($post, 'login ="'.$login.'"');
	}
}

/* End of file admin/models/User.php */
