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
			include('../inc_design/inc_default_header.php'); 
		?>
	</div>
	<!-- END Header -->
	
	<!-- Content -->
	<div id="content">
		<div class="container index">
			<div class="col primary">
				<div class="tagline">See what's inside</div>
				<div class="plug"><a href="http://github.com/diilbert/" title="Fork me on GitHub"><img src="images/logo_github_huge.png" alt="Fork me on GitHub" title="Fork me on GitHub"/></a></div>
				<div class="forkme"><a href="http://github.com/diilbert/RobinHills.com/" title="RobinHills.com on GitHub">Fork this website</a></div>
				<div class="connecttome"></div>
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
					<div class="tweet"><?PHP echo $tweet['text'];?> | <?PHP echo date('M d, Y @ H:i T',$tweet['date']);?></div>
					<?PHP
				}
								
				?>
				<div class="ahead">
					<h4>... and sometimes I am here</h4>
					<div class="logo"><a href="/blog.php?feed" title="My feed"><img src="images/logo_rss_not_huge.gif" title="My feed" alt="My feed" /></a></div>
					<div class="clear"></div>
				</div>
				<?PHP
				$posts = new Posts();
				$posts->All(false,5);
				
				foreach($posts->Results as $post)
				{
					?>
					<div class="post"><a href="<?PHP echo Posts::Url($post);?>" title=""><?PHP echo $post['title'];?></a> | <?PHP echo date('M d, Y @ H:i T',strtotime($post['postDate']));?></div>
					<?PHP
				}
				
				?>
			</div>
			<div class="col info">
				<div class="infobox">
					<div class="picture"><img src="http://www.gravatar.com/avatar/<?=md5("robin.hills@gmail.com");?>?s=96" alt="Profile Picture" title="Profile"/></div>
					<div class="details">
						<h3>About me</h3>
						<div class="flagbox">
							<p>You dream it.  I will make it real.</p>
							<p>You design it.  I will style it.</p>
							<p>You break it.  I will fix it.</p>
						</div>
						<div class="cloudbox">
							<p>Some of the technologies I have experience with:</p>
							<span data-weight="10">PHP 5</span>
							<span data-weight="8">MySQL Server</span>
							<span data-weight="2">MySQL Cluster</span>
							<span data-weight="10">HTML</span>
							<span data-weight="6">CSS</span>
							<span data-weight="6">JavaScript</span>
							<span data-weight="5">jQuery &amp; MooTools</span>
							<span data-weight="7">Red Hat &amp; Debian/GNU Linux</span>
							<span data-weight="6">C# Mono/.Net</span>
							<span data-weight="4">Subversion</span>
							<span data-weight="3">Apache Solr/Lucene</span>
							<span data-weight="0.5">Oracle</span>
							<span data-weight="0.5">CA Clarity PPM Studio</span>
						</div>
					</div>
					<div class="clear"></div>
					
					<div class="skillbox">
						<p>My current responsibilities include:</p>
						<span data-weight="30">Web development and design</span>
						<span data-weight="20">Solutions design</span>
						<span data-weight="5">Infrastructure planning</span>
						<span data-weight="25">Server administation</span>
						<span data-weight="10">Database optimization</span>
						<span data-weight="10">Performance tuning</span>
					</div>
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
