<?PHP

// MySQL configuration
$db_profile = array(
						'username' => 'root', 
						'password' => '',
						'database' => 'main', 
						'host' => 'localhost'
						);
// Glorified debug mode
define("MODE_DEV",true);

// Autodetect paths
// Modify if required						
define('ROOT_PATH',realpath(dirname(__FILE__)."/../")."/");						
define('IMAGE_PATH',ROOT_PATH.'dynamic/');



?>
