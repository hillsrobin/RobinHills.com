<?PHP
	if($_SERVER['DEV'] == 'TRUE')
	{
		error_reporting(E_ALL & ~E_NOTICE);
		ini_set('display_errors',1);
	}
	
	include_once('../inc_scripts/inc_scripts_common_mysql.php');
	include_once('../inc_scripts/inc_scripts_config.php');
	
	include_once('../inc_scripts/inc_scripts_class_utils.php');
	include_once('../inc_scripts/inc_scripts_class_csstheme.php');
	
	if(is_array($db_profile))
		$db = new SimpleMySQL($db_profile);
	
	include_once('../inc_scripts/inc_scripts_common_verify_logged.php');
	
?>
