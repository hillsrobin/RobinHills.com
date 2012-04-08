<?PHP

// Disable error output <-- will break image output
ini_set('display_errors',0);
include_once('../inc_scripts/inc_scripts_config.php');
include_once('../inc_scripts/inc_scripts_class_utils.php');
include_once('../inc_scripts/inc_scripts_class_image.php');
include_once('../inc_scripts/inc_scripts_common_mysql.php');

if(isset($_GET['id']))
{	
	if(isset($_GET['size']))
		$size = $_GET['size'];
	
	if(isset($_GET['no_aspect']))
		$aspect = false;
	else
		$aspect = true;
	
	list($width,$height) = explode('x',$size);
	
	if(!is_numeric($_GET['id']))
		$filename = Utils::SimpleCipher($image_id);
	else
	{
		if(is_array($db_profile))
			$db = new SimpleMySQL($db_profile);
		
		$filename = $db->QueryAsRow('SELECT filename FROM images WHERE id='.intval($_GET['id']));
		$filename = $filename['filename'];
	}
		
	$img = new Image(IMAGE_PATH.$filename);

	// Make sure not to stretch images
	list($orig_w, $orig_h) = array_values(Image::imageDimensions(IMAGE_PATH.$filename));
	
	if($width > $orig_w)
		$width = $orig_w;
	
	if($height > $orig_h)
		$height = $orig_h;
	
	if(($width > 0) || ($height > 0))		// Only resize if there is a Height or Width set
		$img->resize($width,$height,$aspect);
	
	$img->show();
	
}
?>
