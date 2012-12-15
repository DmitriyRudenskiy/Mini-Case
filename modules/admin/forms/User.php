<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Form_User extends Form_Base
{
	public function init()
	{
		$this->setMethod('post');
		
		$element = new Zend_Form_Element_Submit('btn_save');
		$element->setLabel('Ok')
			->setIgnore(true);
		$this->addElement($element);

		$element = new Zend_Form_Element_Hidden('id');
		$element->removeDecorator('Label')
			->removeDecorator('HtmlTag');
		$this->addElement($element);

		$element = new Zend_Form_Element_Checkbox('is_active');
		$element->setLabel('123');
		$this->addElement($element);

		$element = new Zend_Form_Element_Select('role');
		$element->setLabel(_('Отображать как'))
			->setMultiOptions(array('admin'=> 'Администратор', 'user'=> 'Пользователь'));
		$this->addElement($element);

		$element = new Zend_Form_Element_Text('login');
		$element->setLabel(_('Имя пользователя'))
			->addValidator('regex', false, array('/[a-z]/i'));
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text('first_name');
		$element->setLabel(_('Имя'));
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text('last_name');
		$element->setLabel(_('Фамилия'));
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text('email');
		$element->setLabel(_('E-mail (обязательно)'));
		$this->addElement($element);

		$element = new Zend_Form_Element_Text('password');
		$element->setLabel(_('Новый пароль'));
		$this->addElement($element);
		
		parent::init();

	}
}

/* End of file admin/forms/User.php */