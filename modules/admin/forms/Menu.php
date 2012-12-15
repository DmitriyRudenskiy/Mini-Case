<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Form_Menu extends Form_Base
{
	public function init()
	{
        $id = new Zend_Form_Element_Hidden('id');
        $id->removeDecorator('Label')
            ->removeDecorator('HtmlTag');   
        $this->addElement($id);
        
        $active = new Zend_Form_Element_Checkbox('is_active'); 
        $active->setValue('1')
        	->removeDecorator('Label')
            ->removeDecorator('HtmlTag');
        $this->addElement($active);
		
		$title = new Zend_Form_Element_Text('title');
		$title->setAttrib('class', 'itext')
    		->setRequired(true)
    		->addFilter('StripTags')
    		->addFilter('StringTrim')
    		->addValidator('NotEmpty')
    		->removeDecorator('Label')
            ->removeDecorator('HtmlTag');
		$this->addElement($title);
        
        $description = new Zend_Form_Element_Textarea('description');
        $description->setAttrib('class', 'itext')
            ->setAttrib('rows', '5')
            ->removeDecorator('Label')
            ->removeDecorator('HtmlTag');   
        $this->addElement($description);
	}
}

/* End of file admin/forms/Menu.php */
