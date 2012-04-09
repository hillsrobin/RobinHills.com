<?PHP
include('../inc_scripts/inc_scripts_common_verify_locked.php');
include('../inc_scripts/inc_scripts_class_posts.php');
include_once('../inc_scripts/inc_scripts_class_images.php');

if($_POST['postDate_now'])
	$_POST['postDate'] = date('Y-m-d H:i:s');

$post_data = array(
					'title' => $_POST['title'],
					'body' => $_POST['body'],
					'categories' => $_POST['categories'],
					'tags' => $_POST['tags'],
					'postDate' => $_POST['postDate'],
					'image' => $_POST['image'],
					'status' => $_POST['status']
					);

$filename = Images::HandleUpload('image');
$new_image = new Images();
if(intval($filename[0]) != -1)
	$post_data['image'] = $new_image->Add(array('filename' => $filename[0]));

$post = new Posts(intval($_REQUEST['id']));

$post->Update($post_data);

Utils::Redirect('blog.php');

?>
