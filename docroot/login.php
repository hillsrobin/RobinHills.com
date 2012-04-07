<?PHP
	include('../inc_design/inc_default_origin.php');
	
	if(is_numeric($_SESSION['User']))
		Utils::Redirect('index.php');
	
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
	<script type="text/javascript">
		window.addEvent('load',function(){
				$('username').focus();
		});
	</script>
	<!-- Content -->
	<div id="content">
		<div class="container login">
			<h2>Log In</h2>
			<?PHP
			if(isset($_GET['error']))
			{
				?>
				<div class="failed">Your log in attempt failed</div>
				<?PHP
			}
			?>
			<form id="login" action="function.php?action=login" method="post" autocomplete="off">
			<div class="username">
				<div class="label"><label for="username">Username</label></div>
				<div class="field"><input type="text" name="username" id="username" value="" tabindex="1"/></div>
				<div class="clear"></div>
			</div>
			<div class="password">
				<div class="label"><label for="password">Password</label></div>
				<div class="field"><input type="password" name="password" id="password" value="" tabindex="2"/></div>
				<div class="clear"></div>
			</div>
			<div class="login_button"><input type="submit" value="Log In" tabindex="3"/></div>
			</form>
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
