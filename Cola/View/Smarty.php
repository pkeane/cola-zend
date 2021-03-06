<?php

//incorporates class from zend docs
//and the template inheritance stuff
//from http://www.smarty.net/forums/viewtopic.php?t=8944

class Cola_View_Smarty implements Zend_View_Interface
{
    /**
     * Smarty object
     * @var Smarty
     */
    #protected $_smarty;
    public $_smarty;

	public $_blocks = array();
	public $_derived = null; 

    /**
     * Constructor
     *
     * @param string $tmplPath
     * @param array $extraParams
     * @return void
     */
    public function __construct($tmplPath = null, $extraParams = array())
    {
        $this->_smarty = new Smarty;
        if (null !== $tmplPath) {
            $this->setScriptPath($tmplPath);
        }
        foreach ($extraParams as $key => $value) {
            $this->_smarty->$key = $value;
        }
		$this->_smarty->register_block('block', '_smarty_swisdk_process_block');
		$this->_smarty->register_function('extends', '_smarty_swisdk_extends');
		$this->_smarty->assign_by_ref('_swisdk_smarty_instance', $this);

    }

    /**
     * Return the template engine object
     *
     * @return Smarty
     */
    public function getEngine()
    {
        return $this->_smarty;
    }

    /**
     * Set the path to the templates
     *
     * @param string $path The directory to set as the path.
     * @return void
     */
    public function setScriptPath($path)
    {
        if (is_readable($path)) {
            $this->_smarty->template_dir = $path;
            return;
        }

        throw new Exception('Invalid path provided');
    }

    /**
     * Retrieve the current template directory
     *
     * @return string
     */
    public function getScriptPaths()
    {
        return array($this->_smarty->template_dir);
    }

    /**
     * Alias for setScriptPath
     *
     * @param string $path
     * @param string $prefix Unused
     * @return void
     */
    public function setBasePath($path, $prefix = 'Zend_View')
    {
        return $this->setScriptPath($path);
    }

    /**
     * Alias for setScriptPath
     *
     * @param string $path
     * @param string $prefix Unused
     * @return void
     */
    public function addBasePath($path, $prefix = 'Zend_View')
    {
        return $this->setScriptPath($path);
    }

    /**
     * Assign a variable to the template
     *
     * @param string $key The variable name.
     * @param mixed $val The variable value.
     * @return void
     */
    public function __set($key, $val)
    {
        $this->_smarty->assign($key, $val);
    }

    /**
     * Allows testing with empty() and isset() to work
     *
     * @param string $key
     * @return boolean
     */
    public function __isset($key)
    {
        return (null !== $this->_smarty->get_template_vars($key));
    }

    /**
     * Allows unset() on object properties to work
     *
     * @param string $key
     * @return void
     */
    public function __unset($key)
    {
        $this->_smarty->clear_assign($key);
    }

    /**
     * Assign variables to the template
     *
     * Allows setting a specific key to the specified value, OR passing
     * an array of key => value pairs to set en masse.
     *
     * @see __set()
     * @param string|array $spec The assignment strategy to use (key or
     * array of key => value pairs)
     * @param mixed $value (Optional) If assigning a named variable,
     * use this as the value.
     * @return void
     */
    public function assign($spec, $value = null)
    {
        if (is_array($spec)) {
            $this->_smarty->assign($spec);
            return;
        }

        $this->_smarty->assign($spec, $value);
    }

    /**
     * Clear all assigned variables
     *
     * Clears all variables assigned to Zend_View either via
     * {@link assign()} or property overloading
     * ({@link __get()}/{@link __set()}).
     *
     * @return void
     */
    public function clearVars()
    {
        $this->_smarty->clear_all_assign();
    }

    /**
     * Processes a template and returns the output.
     *
     * @param string $name The template to process.
     * @return string The output.
     */
    public function render($name)
    {
		//gussied up w/ inheritance logic
		$ret = $this->_smarty->fetch($name);
		while($resource = $this->_derived) {
			$this->_derived = null;
			$ret = $this->_smarty->fetch($resource);
		}
		return $ret; 
    }

}

//standalone functions

function _smarty_swisdk_process_block($params, $content, &$smarty, &$repeat)
{
	if($content===null)
		return;
	$name = $params['name'];
	$ss = $smarty->get_template_vars('_swisdk_smarty_instance');
	if(!isset($ss->_blocks[$name])) {
		$ss->_blocks[$name] = $content;
	}
	return $ss->_blocks[$name];
}

function _smarty_swisdk_extends($params, &$smarty)
{
	$ss = $smarty->get_template_vars('_swisdk_smarty_instance');
	$ss->_derived = $params['file'];
}

