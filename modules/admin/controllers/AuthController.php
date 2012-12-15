<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class AuthController extends Zend_Controller_Action
{
	public function indexAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			return;
		}
		
		$form = new Form_Login();
		
		$this->view->base_url = 'http://'.$_SERVER['HTTP_HOST'] . '/admin/';
		$this->view->message = '';

		if ($this->_request->isPost()  && $form->isValid($this->_request->getPost())) {
			
			$model = new Model_Auth();
			
			$adapter = $model->getAuthAdapter(
    			$form->getValue('username'),
    			$form->getValue('password')
			);

			$result = Zend_Auth::getInstance()->authenticate($adapter);
			
			if ($result->isValid()) {
			
				$user = $adapter->getResultRowObject(array(
					'login',
					'role'
				));
				
				$user->session_ip = $_SERVER['REMOTE_ADDR'];
			
				Zend_Auth::getInstance()->getStorage()->write($user);

				$this->_redirect('/');
				return;
			} else {
				$this->view->error = true;
			}
		}	
		
		$this->view->form = $form;
	}
    
    public function logoutAction()
    {
    	Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');
    	Zend_Auth::getInstance()->clearIdentity();
    	
    	$this->_redirect('/');
    }

}

/* End of file admin/controllers/AuthController.php */
