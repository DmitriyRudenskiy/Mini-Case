<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Form_Image extends Form_Base
{
	public function init()
	{
		$id = new Zend_Form_Element_Hidden('id');
		$id->removeDecorator('Label')
			->removeDecorator('HtmlTag');
		
		$active = new Zend_Form_Element_Checkbox('is_visible');
		$active->setValue('1');
		$this->addElement($active);
		
		$idCategory = new Zend_Form_Element_Select('category_id');
		$idCategory->setAttrib('class', 'iselect')
			->addFilter('Int')
    		->removeDecorator('Label')
    		->removeDecorator('HtmlTag');
		$this->addElement($idCategory);

		$name = new Zend_Form_Element_Text('name');
		$name->setAttrib('class', 'itext')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->removeDecorator('Label')
			->removeDecorator('HtmlTag');

		$title = new Zend_Form_Element_Text('title');
		$title->setAttrib('class', 'itext')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->removeDecorator('Label')
			->removeDecorator('HtmlTag');

		$alt = new Zend_Form_Element_Text('alt');
		$alt->setAttrib('class', 'itext')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->removeDecorator('Label')
			->removeDecorator('HtmlTag');

		$this->addElements(
			array(
				$id,
				$idCategory,
				$name,
				$title,
				$alt
			)
		);
	}
}

/* End of file admin/forms/Image.php */
