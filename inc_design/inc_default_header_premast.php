		<div id="premast">
			<div class="box">
				<div class="left">
					<div class="menu_item"><a href="/">Home</a></div>
					<div class="menu_item"><a href="blog.php">Blog</a></div>
					<div class="menu_item"><a href="contact.php">Contact</a></div>
				</div>
				<div class="right">
					
					<?PHP
					if(is_numeric($_SESSION['User']))
					{
						?>
						<div class="menu_item link_login"><a href="function.php?action=logout">Log Out</a></div>
						<?PHP
					}
					else
					{
						?>
						<div class="menu_item link_login"><a href="login.php">Log In</a></div>
						<?PHP
					}
					?>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</div>