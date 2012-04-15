<?PHP
	include('../inc_design/inc_default_origin.php');
	include_once('../inc_scripts/inc_scripts_class_profile_twitter.php');
	include_once('../inc_scripts/inc_scripts_class_posts.php');
	
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
			<div class="col primary">
				<div class="tagline">See what's inside <br /><span class="comment">&lt;!-- <br />insert fancy arrow here <br />--&gt;</span></div>
				<div class="plug"><a href="http://github.com/diilbert/RobinHills.com/" title="Fork me on GitHub"><img src="images/logo_github_huge.png" alt="Fork me on GitHub" title="Fork me on GitHub"/></a></div>
			</div>
			<div class="col latest">
				<h3>Latest</h3>
				<div class="ahead">
					<h4>I am mostly here</h4>
					<div class="logo"><a href="http://twitter.com/#!/rdhills/" title="Follow me on Twitter"><img src="images/logo_twitter_huge.png" title="Follow me on Twitter" alt="Follow me on Twitter" /></a></div>
					<div class="clear"></div>
				</div>
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
				
				<h4>... and sometimes I am here</h4>
				<?PHP
				$posts = new Posts();
				$posts->All(false,5);
				
				foreach($posts->Results as $post)
				{
					?>
					<div class="post"><a href="<?PHP echo Posts::Url($post);?>" title=""><?PHP echo $post['title'];?></a> <?PHP echo date('Y-m-d H:i',strtotime($post['postDate']));?></div>
					<?PHP
				}
				
				?>
			</div>
			<div class="col info">
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
