<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class UserController extends Zend_Controller_Action
{
	protected $_auth;
	
	public function init()
	{
		$this->_auth = Zend_Auth::getInstance();
	}
	
    public function loginAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	
        $form = new forms_Login();

        if ($this->_request->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                
                $login = $form->getElement('login')->getValue();
                $password = $form->getElement('password')->getValue();
                
                $model = new models_User();
                	
                $adapter = $model->getAuthAdapter($login, $password);
                
                $result = $this->_auth->authenticate($adapter);
                
                if ($result->isValid()) {
                
                	$user = $adapter->getResultRowObject(
						array(
							'first_name',
							'last_name',
							'role'
						)
                	);
                
                	$this->_auth->getStorage()->write($user);
                
                	// log last vizit
                	$model->lastVizit($user->login);
                }
            }
        }
        
        if (empty($_SERVER['HTTP_REFERER'])) {
        	$url = 'http://'.$_SERVER['HTTP_HOST'];
        } else {
        	$url = $_SERVER['HTTP_REFERER'];
        }
         
        $this->_redirect($url);
    }
    
    public function logoutAction()
    {
		if ($this->_auth->hasIdentity()) {
            $this->_auth->clearIdentity();
		}
		
		if (empty($_SERVER['HTTP_REFERER'])) {
			$url = 'http://'.$_SERVER['HTTP_HOST'];
		} else {
			$url = $_SERVER['HTTP_REFERER'];
		}
        
        $this->_redirect($url);
    }
}
/* End of file application/controllers/UserController.php */
