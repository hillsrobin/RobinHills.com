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
			include('../inc_design/inc_default_header_premast.php'); 
		?>
		<div id="top"></div>
	</div>
	<!-- END Header -->
	
	<!-- Content -->
	<div id="content">
		<div class="container index">
			<div class="col first">
				<h3>Where to find me</h3>
			</div>
			<div class="col skills">
				<h3>Skills</h3>
				<div>Web design</div>
				<div>Web development</div>
				<div>Agile development</div>
				<div>Solution design</div>
				<div>Infrastructure planning</div>
				<div>Server administation</div>
				<div>Database optimization</div>
				<div>Performance tuning</div>
				<div class="clear"></div>
			
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
				<div class="clear"></div>
			</div>
			<div class="col">
				<div class="infobox">
					<img src="http://www.gravatar.com/avatar/<?=md5("robin.hills@gmail.com");?>?s=96" alt="" title=""/>
				</div>
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
