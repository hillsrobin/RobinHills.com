<?PHP
if(is_numeric($_SESSION['User']))
{
	?>
	<div class="box">
		<h3>Administration</h3>
		<div class="admin">
			<div class="option"><a href="post.php?action=add" title="Add Post">Add Post</a></div>
		</div>
	</div>
	<?PHP
}
?>
