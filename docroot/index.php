<?PHP
	include('../inc_design/inc_default_origin.php');
	
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
				?>
			</div>
			<div class="left">
				Left
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
