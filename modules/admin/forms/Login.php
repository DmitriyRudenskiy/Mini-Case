<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Form_Login extends Form_Base
{
   public function init()
   {
        $userName = new Zend_Form_Element_Text('username');
        $userName->setAttrib('class', 'itext')
	        ->setRequired(true)
	        ->addValidator('NotEmpty')
	        ->addFilter('StripTags')
	        ->addFilter('StringTrim')
	        ->removeDecorator('Label')
	        ->removeDecorator('HtmlTag');
        $this->addElement($userName);
        
        $password = new Zend_Form_Element_Password('password');
        $password->setAttrib('class', 'itext')
	        ->setRequired(true)
	        ->addValidator('NotEmpty')
	        ->addFilter('StripTags')
	        ->addFilter('StringTrim')
	        ->removeDecorator('Label')
	        ->removeDecorator('HtmlTag');
        $this->addElement($password);
   }
}

/* End of file admin/forms/Login.php */