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

class system_Twig extends Zend_View_Abstract
{
	protected $_engine;
	protected $_variables = array();

	/**
	 * Constructor.
	 *
	 * @param array $config Configuration key-value pairs.
	 */
	public function  __construct($config = array())
	{
		if (isset($config['cache'])) {
			$config['params']['cache'] = $_SERVER['DOCUMENT_ROOT'] . $config['cache'];
		}
		
		$this->_engine = new Twig_Environment(
			new Twig_Loader_Filesystem(BASE_PATH . '/views'),
		    $config['params']
		);
		
		$this->_engine->removeExtension('escaper');
		$this->_engine->removeExtension('optimizer');
	}
	
	/**
	 * Return the template engine object
	 *
	 * Returns the object instance, as it is its own template engine
	 *
	 * @return Zend_View_Abstract
	 */
	public function getEngine()
    {
        return $this->_engine;
    }
	
	/**
     * Directly assigns a variable to the view script.
     *
     * Checks first to ensure that the caller is not attempting to set a
     * protected or private member (by checking for a prefixed underscore); if
     * not, the public member is set; otherwise, an exception is raised.
     *
     * @param string $key The variable name.
     * @param mixed $val The variable value.
     * @return void
     * @throws Zend_View_Exception if an attempt to set a private or protected
     * member is detected
     */
    public function __set($key, $value)
	{
		$this->_variables[$key] = $value;
	}
	
	/**
	 * Allows testing with empty() and isset() to work inside
	 * templates.
	 *
	 * @param  string $key
	 * @return boolean
	 */
	public function __isset($key)
	{
		return isset($this->_variables[$key]);
	}
	
	/**
	 * Allows unset() on object properties to work
	 *
	 * @param string $key
	 * @return void
	 */
	public function __unset($key)
	{
		unset($this->_variables[$key]);
	}
	
	/**
     * Assigns variables to the view script via differing strategies.
     *
     * Zend_View::assign('name', $value) assigns a variable called 'name'
     * with the corresponding $value.
     *
     * Zend_View::assign($array) assigns the array keys as variable
     * names (with the corresponding array values).
     *
     * @see    __set()
     * @param  string|array The assignment strategy to use.
     * @param  mixed (Optional) If assigning a named variable, use this
     * as the value.
     * @return Zend_View_Abstract Fluent interface
     * @throws Zend_View_Exception if $spec is neither a string nor an array,
     * or if an attempt to set a private or protected member is detected
     */
    public function assign($spec, $value = null)
	{
		if (!is_null($value)) {
			$this->_variables[$spec] = $value;
		} elseif (is_array($spec)) {
			$this->_variables = array_merge($this->_variables, $spec);
		}
	}
	
	/**
	 * Clear all assigned variables
	 *
	 * Clears all variables assigned to Zend_View either via {@link assign()} or
	 * property overloading ({@link __set()}).
	 *
	 * @return void
	 */
	public function clearVars()
	{
		$this->_variables = array();
	}
	
	/**
	 * Processes a view script and returns the output.
	 *
	 * @param string $name The script name to process.
	 * @return string The script output.
	 */
	public function render($name)
	{
		$template = $this->_engine->loadTemplate($name);
		return $template->render($this->_variables);
	}

	/**
	 * Use to include the view script in a scope that only allows public
	 * members.
	 *
	 * @return mixed
	 */
	public function _run()
	{

	}
}

/* End of file .php */
/* End of file system/Twig.php */
