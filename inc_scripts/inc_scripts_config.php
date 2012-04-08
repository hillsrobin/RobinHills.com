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

// Define the Cookie Domain Based on the current host name
if(is_numeric(str_replace(".","",$_SERVER['HTTP_HOST']))) // Dotted address
	define('COOKIE_DOMAIN',$_SERVER['HTTP_HOST']);
else
{
	$_http_host = $_SERVER['HTTP_HOST'];
	$_http_host = ".".preg_replace("/^[a-z0-9]+\./","",$_http_host);
		
	define('COOKIE_DOMAIN',$_http_host);
}

?>
