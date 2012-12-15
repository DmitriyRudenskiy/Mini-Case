<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Form_Category extends Form_Base
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
		$element->setLabel('123')
			->setAttrib('class', 'span4');
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select('parent_id');
		$element->setLabel('123')
			->setAttrib('class', 'span4');
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select('type');
		$element->setLabel('123')
			->setAttrib('class', 'span4');
		$this->addElement($element);

		$element = new Zend_Form_Element('link');
		$element->setLabel('123')
			->setAttrib('class', 'span4')
			->addValidator('regex', false, array('/[a-z]/i'));
		$this->addElement($element);

		$element = new Zend_Form_Element_Text('name');
		$element->setLabel('123')
			->setAttrib('class', 'span4')
			->setRequired(true)
			->addValidator('NotEmpty');
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

/* End of file admin/forms/Category.php */
