<?PHP
	include('../inc_design/inc_default_origin.php');
	include_once('../inc_scripts/inc_scripts_class_posts.php');
	
	$posts = new Posts();
	
	if(isset($_GET['category']))
		$posts->byCategory(urldecode(str_replace('-','+',$_GET['category'])));
	else if(isset($_GET['archive']))
		$posts->byMonth(urldecode($_GET['archive']));
	else
		$posts->All();
	
	include('../inc_design/inc_default_doctype.php'); 
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">	
<head>
	<?PHP
			include('../inc_design/inc_default_head.php'); 
	?>
</head>

	
<body>
		
	<!-- Header -->
	<div id="header">
		<?PHP
			include('../inc_design/inc_default_header.php'); 
		?>
	</div>
	<!-- END Header -->
	
	<!-- Content -->
	<div id="content">
		<div class="container index">
			<div class="right">
				<?PHP
					include('../inc_design/inc_default_left_profile.php');
					include('../inc_design/inc_default_left_administration.php');
					include('../inc_design/inc_default_left_archives.php');
					include('../inc_design/inc_default_left_categories.php');
				?>
			</div>
			<div class="left">
				<?PHP 
				if(!$posts->isError)
				{
					foreach($posts->Results as $post)
					{
						include('../inc_design/inc_post_body.php');
					}
				}
				else
					echo 'No Posts'; 
				?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<!-- END Content -->
	
	<!-- Footer -->
	<div id="footer">
		<?PHP
			include('../inc_design/inc_default_footer.php'); 
		?>
	</div>
	<!-- END Footer -->
	
</body>
</html>
