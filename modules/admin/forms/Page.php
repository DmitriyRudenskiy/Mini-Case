<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Form_Page extends Form_Base
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
		
		$element = new Zend_Form_Element_Checkbox('is_active');
		$element->setLabel('Показывать')
        ->setValue('1');		
		$this->addElement($element);

		$element = new Zend_Form_Element_Select('category_id');
		$element->setLabel(_('Родительская рубрика'))
			->setAttrib('class', 'span4');
		$this->addElement($element);

		$element = new Zend_Form_Element_Text('link');
		$element->setLabel(_('Ярлык'))
			->setAttrib('class', 'span4');
		$this->addElement($element);

		$element = new Zend_Form_Element_Text('tag');
		$element->setLabel(_('Метки'))
			->setAttrib('class', 'span7');
		$this->addElement($element);

		$element = new Zend_Form_Element_Text('header');
		$element->setLabel(_('Заголовок'))
			->setAttrib('class', 'span7')
			->setAttrib('id', 'header_page')
			->setRequired(true);
		$this->addElement($element);

		$element = new Zend_Form_Element_Textarea('content');
		$element->removeDecorator('Label')
			->removeDecorator('HtmlTag')
			->setAttrib('class', 'span7')
            ->setRequired(true)
			->setAttrib('id', 'text_content')
			->setAttrib('rows', '5');
		$this->addElement($element);

		$element = new Zend_Form_Element_Textarea('anons');
		$element->setLabel(_('Описание'))
			->setAttrib('class', 'span7')
			->setAttrib('rows', '5');
		$this->addElement($element);

		$element = new Zend_Form_Element_Text('title');
		$element->setLabel('123')
			->setAttrib('class', 'span7');
		$this->addElement($element);

		$element = new Zend_Form_Element_Textarea('description');
		$element->setLabel('123')
			->setAttrib('class', 'span7')
			->setAttrib('rows', 5);
		$this->addElement($element);

		$element = new Zend_Form_Element_Textarea('keywords');
		$element->setLabel('123')
			->setAttrib('class', 'span7')
			->setAttrib('rows', '5');
		$this->addElement($element);
		
		parent::init();

	}
}

/* End of file admin/forms/Page.php */