<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

//front controller is singleton
//this is some set-up
$front = Zend_Controller_Front::getInstance();
$front->setParam('useDefaultControllerAlways', true);

require_once 'Cola/Rest/Route.php';
$restRoute = new Cola_Rest_Route($front);
$front->getRouter()->addRoute('default', $restRoute);
$front->setParam('noViewRenderer', true);

//we don't bootstrap 'view' here, since
//in many cases we don't need it
$resources = array('autoload','db','FrontController');

$application->bootstrap($resources)->run();
