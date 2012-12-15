<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Form_PageFilter extends Form_Baseclear
{
	public function init()
	{
		$this->setMethod('get');

		$element = new Zend_Form_Element_Select('status');
		$element->setAttrib('class', 'span1')
			->setMultiOptions(array('Вкл', 'Выкл', 'Все'));
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Select('category');
		$element->setAttrib('class', 'span2');
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text('link');
		$element->setAttrib('class', 'span3');
		$this->addElement($element);
		
		$element = new Zend_Form_Element_Text('title');
		$element->setAttrib('class', 'span3');
		$this->addElement($element);
	}
}

/* End of file admin/forms/Category.php */
