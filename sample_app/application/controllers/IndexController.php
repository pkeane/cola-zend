<?php

class IndexController extends Cola_Rest_Controller
{

    public function getAction()
    {
		$view = $this->initView();
		$content = $view->render('index.tpl');
		$this->getResponse()
			->appendBody($content);
    }
}

