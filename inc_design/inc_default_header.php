		<?PHP
			echo $theme->getJavascript();
		?>
		<div id="premast">
			<div class="box">
				<div class="left">
				<div><a href="/" title="Home">robinhills.com</a><span> - my take on technology</span></div>
				</div>
				<div class="right">
					<div class="menu_item"><a href="/">Home</a></div>
					<div class="menu_item"><a href="resume.php">Resume</a></div>
				<!--	<div class="menu_item"><a href="portfolio.php">Portfolio</a></div> -->
					<div class="menu_item"><a href="contact.php">Contact</a></div>
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
		
		<div id="masthead"><img src="images/header_<?PHP echo $theme->getName();?>.jpg" alt="robinhills.com" title="robinhills.com"/></div>
	
