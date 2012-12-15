<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Form_Tag extends Form_Base
{
	public function init()
	{
		$element = new Zend_Form_Element_Submit('btn_save');
		$element->setLabel('Ok')
			->setIgnore(true);
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Hidden('id');
		$element->removeDecorator('Label')
			->removeDecorator('HtmlTag');	
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Checkbox('is_visible');
		$element->setLabel('1')
			->setValue('1');		
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text('title');
		$element->setLabel(_('Название'))
			->addValidator('regex', false, array('/^[а-я]/i'))
			->setDescription('Название определяет, как элемент будет отображаться на вашем сайте.')
			->setAttrib('class', 'span4');
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text('alias');
		$element->setLabel(_('Ярлык'))
			->addValidator('regex', false, array('/^[a-z]/i'))
			->setDescription('«Ярлык» — это вариант названия, подходящий для URL. Обычно содержит только латинские буквы в нижнем регистре, цифры и дефисы.')
			->setAttrib('class', 'span4');
		$this->addElement($element);
		
		parent::init();

	}
}

/* End of file admin/forms/Page.php */