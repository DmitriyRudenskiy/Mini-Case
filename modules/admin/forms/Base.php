<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

abstract class Form_Base extends Zend_Form
{
	public function init()
	{
		$this->clearDecorators()->addDecorator('FormElements')
				->addDecorator('HtmlTag', array('tag' => 'div'))
				->addDecorator('Form')
				->addAttribs(array('class' => 'form-horizontal'));

		
		$this->setDecorators(array(
				'FormElements',
				new Zend_Form_Decorator_FormErrors(array
						(
								'ignoreSubForms' => true,
								'showCustomFormErrors'  => true,
								'onlyCustomFormErrors' => false,
								'markupElementLabelEnd' => '</b>',
								'markupElementLabelStart' => '<b>',
								'markupListEnd' => '</div><div style="clear: both;"></div>',
								'markupListItemEnd' => '</span>',
								'markupListItemStart' => '<span>',
								'markupListStart' => '<div id="Form_Errors" class="alert alert-error offset2 span8">',
								'placement' => 'PREPEND'
						)
				),
				'Form',
				
		));

		$data = array(
				Zend_Validate_Alnum::NOT_ALNUM => 'Введенное значение "%value%" неправильное. Разрешены только латинские символы и цифры',
				Zend_Validate_Alnum::STRING_EMPTY => 'Поле не может быть пустым. Заполните его, пожалуйста',
				Zend_Validate_Alpha::NOT_ALPHA => 'Введите в это поле только латинские символы',
				Zend_Validate_Alpha::STRING_EMPTY => 'Поле не может быть пустым. Заполните его, пожалуйста',
				Zend_Validate_Between::NOT_BETWEEN => '"%value%" не находится между "%min%" и "%max%", включительно',
				Zend_Validate_Between::NOT_BETWEEN_STRICT => '"%value%" не находится строго между "%min%" и "%max%"',
				Zend_Validate_Ccnum::LENGTH => '"%value%" должно быть численным значением от 13 до 19 цифр длинной',
				Zend_Validate_Ccnum::CHECKSUM => 'Подсчёт контрольной суммы неудался. Значение "%value%" неверно',
				Zend_Validate_Date::INVALID => '"%value%" - неверная дата',
				Zend_Validate_Date::FALSEFORMAT => '"%value%" - не подходит по формату',
				Zend_Validate_Digits::NOT_DIGITS => 'Значение "%value%" неправильное. Введите только цифры',
				Zend_Validate_Digits::STRING_EMPTY => 'Поле не может быть пустым. Заполните его, пожалуйста',
				Zend_Validate_EmailAddress::INVALID => '"%value%" неправильный адрес електронной почты. Введите его в формате имя@домен',
				Zend_Validate_EmailAddress::INVALID_HOSTNAME => '"%hostname%" неверный домен для адреса "%value%"',
				Zend_Validate_EmailAddress::INVALID_MX_RECORD => 'Домен "%hostname%" не имеет MX-записи об адресе "%value%"',
				Zend_Validate_EmailAddress::DOT_ATOM => '"%localPart%" не соответствует формату dot-atom',
				Zend_Validate_EmailAddress::QUOTED_STRING => '"%localPart%" не соответствует формату указанной строки',
				Zend_Validate_EmailAddress::INVALID_LOCAL_PART => '"%localPart%" не правильное имя для адреса "%value%", вводите адрес вида имя@домен',
				Zend_Validate_Float::NOT_FLOAT => '"%value%" не является дробным числом',
				Zend_Validate_GreaterThan::NOT_GREATER => '"%value%" не превышает "%min%"',
				Zend_Validate_Hex::NOT_HEX => '"%value%" содержит в себе не только шестнадцатеричные символы',
				Zend_Validate_Hostname::IP_ADDRESS_NOT_ALLOWED => '"%value%" - это IP-адрес, но IP-адреса не разрешены ',
				Zend_Validate_Hostname::UNKNOWN_TLD => '"%value%" - это DNS имя хоста, но оно не дожно быть из TLD-списка',
				Zend_Validate_Hostname::INVALID_DASH => '"%value%" - это DNS имя хоста, но знак "-" находится в неправильном месте',
				Zend_Validate_Hostname::INVALID_HOSTNAME_SCHEMA => '"%value%" - это DNS имя хоста, но оно не соответствует TLD для TLD "%tld%"',
				Zend_Validate_Hostname::UNDECIPHERABLE_TLD => '"%value%" - это DNS имя хоста. Не удаётся извлечь TLD часть',
				Zend_Validate_Hostname::INVALID_HOSTNAME => '"%value%" - не соответствует ожидаемой структуре для DNS имени хоста',
				Zend_Validate_Hostname::INVALID_LOCAL_NAME => '"%value%" - адрес является недопустимым локальным сетевым адресом',
				Zend_Validate_Hostname::LOCAL_NAME_NOT_ALLOWED => '"%value%" - адрес является сетевым расположением, но локальные сетевые адреса не разрешены',
				Zend_Validate_Identical::NOT_SAME => 'Значения не совпадают',
				Zend_Validate_Identical::MISSING_TOKEN => 'Не было введено значения для проверки на идентичность',
				Zend_Validate_InArray::NOT_IN_ARRAY => '"%value%" не найдено в перечисленных допустимых значениях',
				Zend_Validate_Int::NOT_INT => '"%value%" не является целочисленным значением',
				Zend_Validate_Ip::NOT_IP_ADDRESS => '"%value%" не является правильным IP-адресом',
				Zend_Validate_LessThan::NOT_LESS => '"%value%" не меньше, чем "%max%"',
				Zend_Validate_NotEmpty::IS_EMPTY => 'Введённое значение пустое, заполните поле"%value%", пожалуйста',
				Zend_Validate_Regex::NOT_MATCH => 'Значение "%value%" не подходит под шаблон регулярного выражения "%pattern%"',
				Zend_Validate_StringLength::TOO_SHORT => 'Длина введённого значения "%value%", меньше чем %min% симв.',
				Zend_Validate_StringLength::TOO_LONG => 'Длина введённого значения "%value%", больше чем %max% симв.',
				Zend_Captcha_Image::BAD_CAPTCHA => 'Введенное значение не соответствует изображению',
		);

		$translator = new Zend_Translate('Array', $data, 'ru_RU');
		$translator->getAdapter()->setLocale(new Zend_Locale('ru_RU'));
		Zend_Validate_Abstract::setDefaultTranslator($translator);

		foreach ($this->getElements() as $element) {
			switch ($element->getType()) {
			case 'Zend_Form_Element_Submit': 
				$cssClass = $element->getAttrib('class');
				$element->setAttrib('class', 'btn btn-primary offset7');
				$element->setDecorators(
								array("ViewHelper",
										array("Errors",
												array("placement" => "append")),
										array("Description",
												array("tag" => "span",
														"class" => "help-block")),
										array(
												array(
														"innerwrapper" => "HtmlTag"),
												array("tag" => "div",
														"class" => "form-actions"))));
				break;

			default:
				$element
						->setDecorators(
								array("ViewHelper",
										array("Description",
												array("tag" => "span",
														"class" => "help-block")),
										array(
												array(
														"innerwrapper" => "HtmlTag"),
												array("tag" => "div",
														"class" => "controls")),
										array("Label",
												array(
														"class" => "control-label")),
										array(
												array(
														"outerwrapper" => "HtmlTag"),
												array("tag" => "div",
														"class" => "control-group"))));
				break;
			}
		}
	}

	public function isValid($data) {
		$isValid = parent::isValid($data);

		foreach ($this->getElements() as $element) {
			if ($element->hasErrors()) {

				$element->addDecorator(
					'HtmlTag',
					array(
						'tag' => 'span',
						'class' => 'control-group error'
					)
				);
			}

		}

		return $isValid;
	}
	
}

/* End of file admin/forms/Base.php */
