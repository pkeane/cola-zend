<?php

class Listmaker_Model_Lists extends Zend_Db_Table_Abstract
{
	protected $_name='list';
	protected $_rowClass = 'Listmaker_Model_List';

	public static function getAll()
	{
		$atts = new Listmaker_Model_Lists();
		return $atts->fetchAll($atts->select()->order(array('name')));
	}
}

