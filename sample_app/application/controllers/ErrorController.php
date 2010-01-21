<?php

//class ErrorController extends Zend_Controller_Action
class ErrorController extends Cola_Rest_Controller 
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
		$view = $this->initView();

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $view->msg = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $view->msg = 'Application error';
                break;
        }
        
        $view->isdev = true;
        $view->exception = $errors->exception;
        $view->request   = $errors->request;
		$content = $view->render('error/index.tpl');
		$this->getResponse()->appendBody($content);
    }
}

