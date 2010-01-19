<?php

class Cola_Rest_Route extends Zend_Controller_Router_Route_Module
{
    /**
     * Constructor
     *
     * @param Zend_Controller_Front $front Front Controller object
     * @param array $defaults Defaults for map variables with keys as variable names
     * @param array $responders Modules or controllers to receive RESTful routes
     */
	public function __construct(Zend_Controller_Front $front) 
	{
        $this->_front      = $front;
        $this->_dispatcher = $front->getDispatcher();
		$this->_defaults = array();
    }

    public function match($request)
    {
        if (!$request instanceof Zend_Controller_Request_Http) {
            $request = $this->_front->getRequest();
        }
        $this->_request = $request;

		//todo: need to deal w/ module key

        $this->_setRequestKeys();

        $path   = $request->getPathInfo();
        $values = array();
        $params = array();
        $path   = trim($path, self::URI_DELIMITER);

		// Determine Action
		$requestMethod = strtolower($request->getMethod());
		if ($requestMethod == 'get') {
			$values[$this->_actionKey] = 'get';
		} else {
			if ($request->getParam('_method')) {
				$values[$this->_actionKey] = strtolower($request->getParam('_method'));
			} elseif ( $request->getHeader('X-HTTP-Method-Override') ) {
				$values[$this->_actionKey] = strtolower($request->getHeader('X-HTTP-Method-Override'));
			} else {
				$values[$this->_actionKey] = $requestMethod;
			}
		} 

        if ($path != '') {
            $path = explode(self::URI_DELIMITER, $path);
			$values[$this->_controllerKey] = array_shift($path);
        } 

		if (!isset($values[$this->_controllerKey])) {
			$values[$this->_controllerKey] = 'index';
		}

		//set path on request so rest controller
		//can match it to a resource & method
		if (is_array($path) && count($path)) {
			$values['_path'] = join('/',$path);
		} else {
			$values['_path'] = '';
		}

        $result = $values + $params;
		return $result;
    }
}
