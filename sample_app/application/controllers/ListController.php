<?php

class ListController extends Cola_Rest_Controller
{

	public $resource_map = array(
		'{id}' => 'list',
		'ab/cd/ef/gh' => 'secret',
	);

	public function setup()
	{
		$this->baseUrl = $this->getRequest()->getBaseUrl();
		$this->r = $this->getRequest();
		$this->fmt = $this->getRequest()->getParam('_format');
	}

	public function getSecretAction()
	{
		print "bingo"; exit;
	}

	public function getAction()
	{
		$view = $this->initView();
		$view->lists = Listmaker_Model_Lists::getAll();
		$content = $view->render('list/show_all.tpl');
		$this->getResponse()
			->setHeader('Content-Type', $this->fmt)
			->appendBody($content);
	}

	public function getListAction()
	{
		$view = $this->initView();
		$view->list = Listmaker_Model_List::get($this->r->getParam('id'));
		$content = $view->render('list/show_one.tpl');
		$this->getResponse()
			->setHeader('Content-Type', $this->fmt)
			->appendBody($content);
	}

	public function postToAction() 
	{
		$name = $this->getRequest()->getParam('name');
		$list = Listmaker_Model_List::get();
		$list->name = $name;
		$list->save();
		$this->getResponse()
			->setRedirect($this->baseUrl.'/list');
	}

	public function deleteAction() 
	{
		print "delete action"; exit;
	}
}



