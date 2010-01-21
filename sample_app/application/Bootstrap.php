<?php

date_default_timezone_set('America/Chicago');

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Cola_');

		$autoloader = new Zend_Application_Module_Autoloader(array(
			'namespace' => 'Listmaker_',
			'basePath'  => dirname(__FILE__),
		));
		return $autoloader;
	}

	protected function _initView()
	{
		//too expensive to do on every request
		//should only run if/when needed (in controller method)
		require_once 'smarty/libs/Smarty.class.php';
		$smarty_config['compile_dir'] = APPLICATION_PATH . '/templates_c';
		return new Cola_View_Smarty(APPLICATION_PATH . '/templates',$smarty_config);
	}
}
