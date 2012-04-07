<?PHP

// Development settings
if($_SERVER['DEV'] == 'TRUE')
{
	$db_profile = array('username' => '[username]', '[password]' => 'swarrior','database' => 'main', 'host' => 'localhost');
	define('IMAGE_PATH','/var/www/dynamic/');
	define('ROOT_PATH','/var/www/');
}
// Live Settings
else
{
	$db_profile = array('username' => '][username]', 'password' => '[password]','database' => 'blog', 'host' => 'localhost');
	define('IMAGE_PATH','/var/www/dynamic/');
	define('ROOT_PATH','/var/www/');
}

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
