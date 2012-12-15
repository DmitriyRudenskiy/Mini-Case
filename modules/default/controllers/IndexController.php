<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class IndexController extends Zend_Controller_Action
{
   public function indexAction()
   {
   	Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');
   }
}

/* End of file application/controllers/FrontedController.php */
