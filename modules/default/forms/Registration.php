<?php

/**
 * @package		miniCase
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @version		0.91
 */

/*
 * Регистрация

Логин 
От 3 до 15 символов. Может содержать латинские буквы, цифры, подчёркивание (_) и дефис (-) 

Имя 
Не более 20 символов. Вы можете использовать латиницу и/или кириллицу 

Фамилия 
Не более 20 символов. Вы можете использовать латиницу и/или кириллицу 

Пол
 Мужской  
 Женский
     
Электронная почта 
Нигде не публикуется, нужна для подтверждения регистрации 

Пароль 
От 8 до 24 символов. Может содержать цифры и латинские буквы 
Повторите пароль  
  
Код с картинки
 */
class forms_Registration extends Zend_Form
{
	public $elementDecorators = array(
			'viewHelper',
			'Errors',
			array(array('data'=>'HtmlTag'),array('tag'=>'span')),
			array('Label',array('tag'=>'span', 'class' => 'label')),
			array(array('row'=>'HtmlTag'),array('tag'=>'li'))
	);
	
	public $buttonDecorators = array(
			'viewHelper',
			'Errors',
			array(array('data'=>'HtmlTag'),array('tag'=>'span')),
			array(array('row'=>'HtmlTag'),array('tag'=>'li'))
	);
	
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('class', 'iform');
		
/* 		$email = new App_Form_Element_Email('email', array(
				'required'    => true,
		));
		$this->addElement($email); */
		
        $password = new Zend_Form_Element_Password('password', array(
            'required'    => true,
            'label'       => 'Пароль:',
            'maxlength'   => '30',
            'validators'  => array('Password'),
        ));
        
        $this->addElement($password);
        
        $passwordApprove = new Zend_Form_Element_Password('password_approve', array(
            'required'    => true,
            'label'       => 'Подтвердите пароль:',
            'maxlength'   => '30',
            'validators'  => array(array('EqualInputs', true, array('password'))),
        )); 
        
        $this->addElement($passwordApprove); 
		
        $element = new Zend_Form_Element_Captcha('captcha', array(
        		'label' => "Введите символы:",
        		'captcha' => array(
        				'captcha'   => 'Image', // Тип CAPTCHA
        				'wordLen'   => 4,
        				'width'     => 260,
        				'timeout'   => 120,
        				'expiration'=> 300,
        				'font'      => Zend_Registry::get('config')->path->rootPublic . 'fonts/arial.ttf',
        				'imgDir'    => Zend_Registry::get('config')->path->rootPublic . 'images/captcha/',
        				'imgUrl'    => '/images/captcha/',
        				'gcFreq'    => 5
        		),
        ));
        
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Button('submit');
        $element->setLabel('Отправить')
        ->setIgnore(true)
        ->setDecorators($this->buttonDecorators);
        $this->addElement($element);
	}
	
	public function loadDefaultDecorators()
	{
		$this->setDecorators(array(
				'FormElements',
				array('HtmlTag', array('tag' => 'ul', 'id'=> 'contact_form')),
				'Form',
		));
	}
}



/* End of file Categories.php *//* End of file admin/forms/Registration.php */
