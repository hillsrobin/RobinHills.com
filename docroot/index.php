<?PHP
	include('../inc_design/inc_default_origin.php');
	include_once('../inc_scripts/inc_scripts_class_profile_twitter.php');
	include_once('../inc_scripts/inc_scripts_class_profile_delicious.php');
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
				<div class="plug"><a href="http://github.com/hillsrobin/" title="Fork me on GitHub"><img src="images/logo_github_huge.png" alt="Fork me on GitHub" title="Fork me on GitHub"/></a></div>
				<div class="forkme"><a href="http://github.com/hillsrobin/RobinHills.com/" title="RobinHills.com on GitHub">Fork this website</a></div>
				
				<div class="tagline timestwo">Connect with me</div>
				<div class="plug"><a href="http://www.linkedin.com/pub/robin-hills/33/a32/ab5" title="Connect with me on LinkedIn"><img src="images/logo_linkedin.png" alt="Connect with me on LinkedIn" title="Connect with me on LinkedIn"/></a></div>
				
				
			</div>
			<div class="col latest">
				<h3>Latest</h3>
				
				<?php
				/*
				<div class="ahead">
					<h4>I am mostly here</h4>
					<div class="logo"><a href="http://twitter.com/#!/rdhills/" title="Follow me on Twitter"><img src="images/logo_twitter_huge.png" title="Follow me on Twitter" alt="Follow me on Twitter" /></a></div>
					<div class="clear"></div>
				</div>
				<?PHP
				$twitter = new Twitter('rdhills');
				$twitter->useCache = true;
				$updates = $twitter->updates();
				$profile = $twitter->profile();
				
				if($updates !== false)
				{
					
					foreach($updates as $tweet)
					{
						?>
						<div class="tweet">
							<div class="text"><?PHP echo $tweet['text'];?></div>
							<div class="date"><?PHP echo date('M d, Y @ H:i T',$tweet['date']);?></div>
						</div>
						<?PHP
					}
				}
				else
					echo "None found";
								*/
				?>
				<div class="ahead">
					<h4>I am sometimes here</h4>
					<div class="logo"><a href="/blog.php?feed" title="My feed"><img src="images/logo_rss_not_huge.gif" title="My feed" alt="My feed" /></a></div>
					<div class="clear"></div>
				</div>
				<?PHP
				$posts = new Posts();
				$posts->All(false,5);
				
				foreach($posts->Results as $post)
				{
					// TODO: Replace this with an actual summary field (cleaner)
					$body = strip_tags(str_replace(array("\r","\n","\t"),"",$post['body']));
					
					if(strlen($body) > 250)
						$body = substr($body,0,250)."<a href=\"".Posts::Url($post)."\" title=\"Read more\">...</a>";
					?>
					<div class="post">
						<div class="title"><a href="<?PHP echo Posts::Url($post);?>" title=""><?PHP echo $post['title'];?></a></div>
						<div class="summary"><?PHP echo $body;?></div>
						<div class="date"><?PHP echo date('M d, Y @ H:i T',strtotime($post['postDate']));?></div>
					</div>
					<?PHP
				}
				
				?>
				<div class="ahead">
					<h4>I bookmark important stuff here</h4>
					<div class="logo"><a href="http://delicious.com/diilbert" title="My Bookmarks"><img src="images/logo_delicious.gif" title="My bookmarks" alt="My bookmarks" /></a></div>
					<div class="clear"></div>
				</div>
				<?PHP
				
				$delicious = new Delicious('diilbert');
				$delicious->useCache = true;
				$updates = $delicious->updates();
				
				if($updates !== false)
				{
					foreach($updates as $mark)
					{
						?>
						<div class="bookmark">
							<div><a href="<?PHP echo $mark['url'];?>" title="Added <?PHP echo date('M d, Y @ H:i T',$mark['date']);?>"><?PHP echo htmlspecialchars($mark['text']);?></a></div>
							<?PHP
							if($mark['tags_url'] != "")
							{
								?>
								<div class="tags"><span>Tags</span> <?PHP echo $mark['tags_url'];?></div>
								<?PHP
							}
							?>
						</div>
						<?PHP
					}
				}
				else
					echo "None found";
				?>
				
			</div>
			<div class="col info">
				<div class="infobox">
					<div class="picture"><img src="http://www.gravatar.com/avatar/<?=md5("robin.hills@gmail.com");?>?s=96" alt="Profile Picture" title="Profile"/></div>
					<div class="details">
						<h3>About me</h3>
						<div class="flagbox">
							<p>
							<?PHP 
							//echo ($profile !== false ? $profile['intro'] : '');
							?>
							 Application developer by day and Husband of one, Father of two by night.
							</p>
						</div>
						<div class="cloudbox">
							<p>Some of the technologies I have experience with:</p>
							<span data-weight="11">PHP 5</span>
							<span data-weight="9">MySQL Server</span>
							<span data-weight="3">MySQL Cluster</span>
							<span data-weight="11">HTML</span>
							<span data-weight="7">CSS</span>
							<span data-weight="7">JavaScript</span>
							<span data-weight="6">jQuery &amp; MooTools</span>
							<span data-weight="8">Red Hat &amp; Debian/GNU Linux</span>
							<span data-weight="7">C# Mono/.Net</span>
							<span data-weight="5">Subversion</span>
							<span data-weight="2">Git</span>
							<span data-weight="4">Apache Solr/Lucene</span>
							<span data-weight="1">Oracle</span>
							<span data-weight="2">CA Clarity PPM Studio</span>
							<span data-weight="1">SQL Server</span>
						</div>
					</div>
					<div class="clear"></div>
					
					<div class="skillbox">
						<p>My current responsibilities include:</p>
						<span data-weight="50">Database administration</span>
						<span data-weight="10">Web design and development</span>
						<span data-weight="25">Server administation</span>
						<span data-weight="15">Performance tuning</span>
					</div>
					
					<!--
					<div class="projectbox">
						<div>The projects I am currently working on:</div>
						<p><strong><a href="#" title="Visit www.robinhills.com">RobinHills.com</a></strong></p>
						<div>This website</div>
						
						<p><strong><a href="http://www.careerbeacon.com" title="Visit www.careerbeacon.com">CareerBeacon</a></strong></p>
						<div>Full service Atlantic Canadian focused Career website</div>
						
						<p><strong><a href="http://www.jobsinnl.ca" title="Visit www.jobsinnl.ca">JOBSinNL.ca</a></strong></p>
						<div>Newfoundland and Labrador's comprehensive job search and posting website.</div>
						
						<p><strong><a href="https://www.jobgo.ca" title="Visit www.jobgo.ca">JobGO.ca</a></strong></p>
						<div>A French language job website targeting the Queb&#233;c market.</div>
					</div>
					-->
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
