<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class ErrorController extends Zend_Controller_Action
{
	public function errorAction()
	{
		$errors = $this->_getParam('error_handler');

		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				$this->_forward('found', 'error');
			default:
				$this->_forward('work', 'error');
		}

		$this->view->env = $this->getInvokeArg('env');
		$this->view->exception = $errors->exception;
		$this->view->request = $errors->request;

	}
	
	public function accessAction()
	{
		if (!empty($_SERVER['HTTP_REFERER'])) {
			$this->view->url = $_SERVER['HTTP_REFERER'];
		}
	}
	
	
}

/* End of file admin/controllers/ErrorController.php */