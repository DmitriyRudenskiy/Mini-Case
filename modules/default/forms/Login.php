<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Form_Login extends Zend_Form
{
    public function init()
    {
        $decors = array(
            'ViewHelper',
            'Errors', array(array('data'=>'HtmlTag'),array('tag'=>'li'))
        );
        
        $this->setAction('http://zend.test/login');
        
        $email = new Zend_Form_Element_Text('login');
        $email->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty')
        	->setAttrib('placeholder', 'Введите логин')
        	->setDecorators($decors)
        	->removeDecorator('Label');
        $this->addElement($email);
        
        $password = new Zend_Form_Element_Password('password');
        $password->setRequired(true)
	        ->addFilter('StripTags')
	        ->addFilter('StringTrim')
	        ->addValidator('NotEmpty')
	        ->setAttrib('placeholder', 'Введите пароль')
        	->setDecorators($decors)
        	->removeDecorator('Label');
        $this->addElement($password);
        
        $submit = new Zend_Form_Element_Button('submit');
        $submit->setLabel('Войти')
        	->setIgnore(true)
        	->setDecorators($decors)
	        ->removeDecorator('Label');
        $this->addElement($submit);
        
        $this->addDecorators(array(
        	'FormElements',
        	array(
        		array('data'=>'HtmlTag', 'tag'=>'ul'),
        		array('tag'=>'ul','class'=>'login-form')
        	)
        ));
        
        $this->addDecorators(array('tag'=>'form'));
    }
}

/* End of file application/forms/Login.php */