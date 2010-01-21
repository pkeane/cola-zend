<?php

class Listmaker_Model_List extends Zend_Db_Table_Row_Abstract 
{
	public static function get($id='') 
	{
		if ($id) {
			$lists = new Listmaker_Model_Lists;
			return $lists->find($id)->current();
		} else {
			$lists = new Listmaker_Model_Lists;
			return $lists->createRow();
		}

	}
}

