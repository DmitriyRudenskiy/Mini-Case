<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Form_Menuitem extends Form_Base
{
	public function init()
	{
		$id = new Zend_Form_Element_Hidden('id');
		$this->addElement($id);
		
		$active = new Zend_Form_Element_Checkbox('is_visible');
		$active->setValue('1')
			->removeDecorator('Label')
			->removeDecorator('HtmlTag');
		$this->addElement($active);
		
		
		$idCategory = new Zend_Form_Element_Select('parent_id');
		$idCategory->addFilter('Int');
		$this->addElement($idCategory);
		
		$idMenu = new Zend_Form_Element_Select('menu_id');
		$idMenu->addFilter('Int');
		$this->addElement($idMenu);
		
		$place = new Zend_Form_Element_Text('position');
		$place->setAttrib('class', 'itext')
    		->setRequired(true)
    		->addFilter('Int');
		$this->addElement($place);
		
		$title = new Zend_Form_Element_Text('label');
		$title->setAttrib('class', 'itext')
    		->setRequired(true)
    		->addFilter('StripTags')
    		->addFilter('StringTrim')
    		->addValidator('NotEmpty');
		$this->addElement($title);

		$url = new Zend_Form_Element_Text('link');
		$url->setAttrib('class', 'itext')
			->setRequired(true)
    		->addFilter('StripTags')
    		->addFilter('StringTrim')
    		->addValidator('NotEmpty');
		$this->addElement($url);
	}
}

/* End of file admin/forms/MenuItem.php */
