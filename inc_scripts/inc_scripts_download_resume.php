<?PHP

include_once('../inc_scripts/inc_scripts_class_download.php');

switch($_GET['download'])
{
	case 'pdf':
		$filename = 'ROBIN_HILLS-RESUME.pdf';
		break;
	case 'word':
		$filename = 'ROBIN_HILLS-RESUME.doc';
		break;
	case 'odt':
		$filename = 'ROBIN_HILLS-RESUME.odt';
		break;
	
}

if($filename != '')
	new Download(ROOT_PATH.'docroot/resume/'.$filename);


?>
