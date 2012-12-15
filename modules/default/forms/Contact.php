<?php

/**
 * Форма обратной связи
 *
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class forms_Contact extends Zend_Form
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
		
    	$element = new Zend_Form_Element_Text('name');
        $element->setLabel('Ваше имя (обязательно)')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty')
        	->setDecorators($this->elementDecorators);
        $this->addElement($element);
		
		$element = new Zend_Form_Element_Text('email');
        $element->setLabel('Ваш E-Mail (обязательно)')
        	->setRequired(true)
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->addValidator('NotEmpty')
        	->setDecorators($this->elementDecorators);
        $this->addElement($element);
		
		$element = new Zend_Form_Element_Text('subject');
        $element->setLabel('Тема')
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->setDecorators($this->elementDecorators);
        $this->addElement($element);
		
		$element = new Zend_Form_Element_Textarea('message');
        $element->setLabel('Сообщение')
			->setAttrib('rows', '5')
        	->addFilter('StripTags')
        	->addFilter('StringTrim')
        	->setDecorators($this->elementDecorators);
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