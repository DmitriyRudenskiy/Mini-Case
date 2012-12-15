<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

abstract class Model_Base extends Zend_Db_Table_Abstract
{
	public  function init()
	{
		$this->_name = PREFIX . $this->_name;
	}
}

/* End of file application/model/Base.php */
