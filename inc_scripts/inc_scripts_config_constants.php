<?PHP
// Define the Cookie Domain Based on the current host name
if(is_numeric(str_replace(".","",$_SERVER['HTTP_HOST']))) // Dotted address
	define('COOKIE_DOMAIN',$_SERVER['HTTP_HOST']);
else
{
	$_http_host = $_SERVER['HTTP_HOST'];
	$_http_host = ".".preg_replace("/^[a-z0-9]+\./","",$_http_host);
		
	define('COOKIE_DOMAIN',$_http_host);
}

define('HOST_WWW', 1);
define('HOST_DADDY', 2);

// Set the host id based on domain
switch($_SERVER['HTTP_HOST'])
{
	case 'daddy.robinhills.com':
	case 'daddydev.robinhills.com':
		define('HOST_ID',HOST_DADDY);
		define('HOST_THEME','daddy');
		define('HOST_TITLE','Daddy&#39;s Notes');
		break;
		
	case 'devblog.robinhills.com':
	case 'www.robinhills.com':
	default:
		define('HOST_ID',HOST_WWW);
		define('HOST_THEME','default');
		define('HOST_TITLE','robinhills.com');
		break;
}

?>
