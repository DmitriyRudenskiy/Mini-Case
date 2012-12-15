<?php

/**
 * Название
 *
 * Описание
 *
 * @package		miniCase
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @version		0.91
 */

class plugins_Contact
{
    /**
     * {contact}{/contact}
     */
    public function find($text)
    {
    	$content = new forms_Registration();
    	$text = str_replace('{contact}{/contact}', $content, $text);
    	
    	return $text;
    }

}
/* End of file application/plugin/Contact.php */
