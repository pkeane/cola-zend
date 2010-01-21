<?php
error_reporting(1);

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

// Initialize Zend_Application
$application = new Zend_Application(
	APPLICATION_ENV,
	APPLICATION_PATH . '/configs/application.ini'
);

// Initialize and retrieve DB resource
$bootstrap = $application->getBootstrap();
$bootstrap->bootstrap();
//$bootstrap->bootstrap('db');
$db = $bootstrap->getResource('db');

function capFirst (&$item,$key) {
	$item = ucfirst($item);
}

function createModels($namespace,$table,$class_dir) {

	$parts = explode('_',$table);
	array_walk($parts,'capFirst');
	$class_root_name = implode('',$parts);

	$table_class_text = "<?php

class {$namespace}_Model_{$class_root_name}s extends Zend_Db_Table_Abstract
{
	protected \$_name='$table';
	protected \$_rowClass = '{$namespace}_Model_{$class_root_name}';

	public static function getAll()
	{
		\$model = new {$namespace}_Model_{$class_root_name}s;
		//return \$model->fetchAll(\$model->select()->order(array('name')));
		return \$model->fetchAll();
    }
}
";		

$db_class_filepath = $class_dir . '/' . $class_root_name . 's.php';
$fh = fopen($db_class_filepath,'w');
if (-1 == fwrite($fh,$table_class_text)) { 
	die("no go write $db_class_filepath"); 
}
fclose($fh) or die("no go close");
print "created $db_class_filepath\n";

	$row_class_text = "<?php

class {$namespace}_Model_{$class_root_name} extends Zend_Db_Table_Row_Abstract
{
	public static function get(\$id='') 
	{
		if (\$id) {
			\$set = new {$namespace}_Model_{$class_root_name}s;
			return \$set->find(\$id)->current();
		} else {
			\$set = new {$namespace}_Model_{$class_root_name}s;
			return \$set->createRow();
		}
}
";		

$db_class_filepath = $class_dir . '/' . $class_root_name . '.php';
$fh = fopen($db_class_filepath,'w');
if (-1 == fwrite($fh,$row_class_text)) { 
	die("no go write $db_class_filepath"); 
}
fclose($fh) or die("no go close");
print "created $db_class_filepath\n";

}

$class_dir = 'models';
if (!file_exists($class_dir)) {
	mkdir ($class_dir,0755);
}

$dbconf = $db->getConfig();
$dbname = $dbconf['dbname'];
$namespace = ucfirst($dbname);
foreach ($db->listTables() as $table) {
	print createModels($namespace,$table,$class_dir);
}
