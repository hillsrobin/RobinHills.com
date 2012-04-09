<?PHP
include('../inc_scripts/inc_scripts_common_verify_locked.php');
include('../inc_scripts/inc_scripts_class_posts.php');

$post = new Posts(intval($_GET['id']));
$post->Delete();

Utils::Redirect('blog.php');
?>
