<?php

/** Zend_Controller_Action */
require_once 'Zend/Controller/Action.php';

class Cola_Rest_Controller extends Zend_Controller_Action
{
	public $r;
	public $resource_map = array();
	public static $mime_types = array(
		'atom' =>'application/atom+xml',
		'cats' =>'application/atomcat+xml',
		'css' =>'text/css',
		'csv' =>'text/csv',
		'default' =>'text/html',
		'gif' =>'image/gif',
		'html' =>'text/html',
		'jpg' =>'image/jpeg',
		'json' =>'application/json',
		'mov' =>'video/quicktime',
		'mp3' =>'audio/mpeg',
		'mp4' =>'video/mp4',
		'png' =>'image/png',
		'pdf' =>'application/pdf',
		'txt' =>'text/plain',
		'uris' =>'text/uri-list',
		'uri' =>'text/uri-list',
		'xhtml' =>'application/xhtml+xml',
		'xml' =>'application/xml',
	);

	public function init()
	{
		$r = $this->getRequest();
		$r = $this->urlMatch($r);
		$r = $this->initFormat($r);
		$r = $this->setAction($r);
		$this->initDb();
		$this->setup($r);
		$this->r = $r;
	}

	public function initDb()
	{
		$bootstrap = $this->getInvokeArg('bootstrap');
		$this->db = $bootstrap->getResource('db');
	}

	public function initView()
	{
		//		$this->r = $this->getRequest();
		$bootstrap = $this->getInvokeArg('bootstrap');
		$bootstrap->bootstrap('view');
		$view = $bootstrap->getResource('view');
		$view->assign('baseUrl',$this->r->getBaseUrl());
		return $view;

	}

	public function setup($r) 
	{}

	protected function initFormat($r)
	{
		$pathinfo = pathinfo($r->getPathInfo());
		if (isset($pathinfo['extension']) && $pathinfo['extension']) {
			$ext = $pathinfo['extension'];
			if (isset(self::$mime_types[$ext])) {
				$r->setParam('_format',$ext);
				$r->setParam('_mime',self::$mime_types[$ext]);
				return $r;
			}
		}
		//next, try '_format=' query param
		$format_param = $r->getParam('_format');
		if ($format_param) {
			if (isset(self::$mime_types[$format_param])) {
				$r->setParam('_mime',self::$mime_types[$format_param]);
				return $r;
			}
		}
		//default
		$r->setParam('_format','html');
		$r->setParam('_mime','text/html');
		return $r;
	}

	protected function urlMatch($r)
	{
		$path = $r->getParam('_path');

		//remove file extension
		$path_parts = explode('.',$path);
		if (in_array(array_pop($path_parts),array_keys(self::$mime_types))) {
			$path = join('.',$path_parts);
		}

		foreach ($this->resource_map as $uri_template => $resource) {
			$uri_regex = $uri_template;

			//default '' resource
			$r->setParam('_resource','');

			//skip regex template stuff if uri_template is a plain string
			if (false !== strpos($uri_template,'{')) {
				//stash param names into $template_matches
				$num = preg_match_all("/{([\w]*)}/",$uri_template,$template_matches);
				if ($num) {
					$uri_regex = preg_replace("/{[\w]*}/","([\w-,.]*)",$uri_template);
				}
			}

			//second, see if uri_regex matches the request uri (a.k.a. path)
			if (preg_match("!^$uri_regex\$!",$path,$uri_matches)) {
				//create parameters based on uri template and request matches
				if (isset($template_matches[1]) && isset($uri_matches[1])) { 
					array_shift($uri_matches);
					$params = array_combine($template_matches[1],$uri_matches);
					//sets params on request
					//(side effect!!!!)
					$r->setParams($params);
				}
				$r->setParam('_resource',$resource);
			}
		}
		return $r;
	}

	protected function setAction($r)
	{
		$orig = $r->getActionName();
		if ('post' == $orig) {
			$orig = 'post to';
		}
		if (!$orig) {
			$orig = 'get';
		}
		$resource = $r->getParam('_resource');
		$format = $r->getParam('_format');
		if ('html' == $format) {
			$r->setActionName($orig.' '.$resource);
			return $r;
		}
		$r->setActionName($orig.' '.$resource.' '.$format);
		return $r;
	}
}
