<?PHP
	include('../inc_design/inc_default_origin.php');
	include_once('../inc_scripts/inc_scripts_class_profile_twitter.php');
	
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
			include('../inc_design/inc_default_header_premast.php'); 
		?>
		<div id="top"></div>
	</div>
	<!-- END Header -->
	
	<!-- Content -->
	<div id="content">
		<div class="container index">
			<div class="col">
				<div class="tagline">See what's inside <br />(insert fancy arrow here)</div>
				<div class="plug"><a href="http://github.com/diilbert/RobinHills.com/" title="Fork me on GitHub"><img src="images/logo_github_huge.png" alt="Fork me on GitHub" title="Fork me on GitHub"/></a></div>
			</div>
			<div class="col">
				<h3>Latest</h3>
				<?PHP
				$twitter = new Twitter('rdhills');
				$twitter->useCache = true;
				$updates = $twitter->updates();
				
				foreach($updates as $tweet)
				{
					?>
					<div class="tweet"><?PHP echo $tweet['text'];?> <?PHP echo date('Y-m-d H:i',$tweet['date']);?></div>
					<?PHP
				}
								
				?>
				<p>Last three blog posts</p>
			</div>
			<div class="col">
				<div class="infobox">
					<img src="http://www.gravatar.com/avatar/<?=md5("robin.hills@gmail.com");?>?s=96" alt="" title=""/>
					<p>Bio</p>
				</div>
			</div>
			<div class="col skills">
				<p>Do something creative here <strong>Usually is pretty dry</strong></p>
				<div class="skillbox">
					<h3>Skills</h3>
					<div>Web design</div>
					<div>Web development</div>
					<div>Agile development</div>
					<div>Solution design</div>
					<div>Infrastructure planning</div>
					<div>Server administation</div>
					<div>Database optimization</div>
					<div>Performance tuning</div>
				</div>
				<div class="techbox">
					<h3>Technologies</h3>
					<div>PHP 5</div>
					<div>MySQL Server</div>
					<div>MySQL Cluster</div>
					<div>XHTML</div>
					<div>CSS</div>
					<div>JavaScript</div>
					<div>jQuery &amp; MooTools</div>
					<div>Red Hat &amp; Debian/GNU Linux</div>
					<div>C# Mono/.Net</div>
					<div>Subversion</div>
					<div>Apache Solr/Lucene</div>
					<div>Oracle</div>
					<div>CA Clarity PPM Studio</div>
				</div>
			</div>
			
			
			<div class="col first">
				&nbsp;
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
