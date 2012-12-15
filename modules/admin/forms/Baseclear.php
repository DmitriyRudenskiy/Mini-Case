<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

abstract class Form_Baseclear extends Zend_Form
{
	public function addElement($element, $name = null, $options = null)
	{
		$name = $element->getName();

		$this->_elements[$name] = $element;
		$this->_elements[$name]->removeDecorator('Label');
		$this->_elements[$name]->removeDecorator('HtmlTag');
		$this->_elements[$name]->removeDecorator('DtDdWrapper');
		$this->_elements[$name]->removeDecorator('Description');

		$this->_setElementsBelongTo($name);

		return $this;
	}
}

/* End of file admin/forms/Base.php */
