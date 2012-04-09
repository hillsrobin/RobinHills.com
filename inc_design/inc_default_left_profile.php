<?PHP

include_once('../inc_scripts/inc_scripts_class_profile_twitter.php');

$twitter = new Twitter();
$twitter->useCache = true;
$profile = $twitter->profile('rdhills');

$avatar = isset($profile['avatar']) && (trim($profile['avatar']) != "") ? $profile['avatar'] : "http://www.gravatar.com/avatar/".md5("robin.hills@gmail.com")."?s=48"; 
	
?>
<div class="box">
	<h3>About</h3>
	<div class="profile">
		<div class="avatar"><img src="<?PHP echo $avatar;?>" alt="" title="" /></div>
		
		<?PHP
		if($profile !== false)
		{
			?>
		<div class="overview">
			<div class="handle">
				<div class="twitter"><a href="http://twitter.com/rdhills" title="Follow me on Twitter"><img src="images/icon_twitter.gif" alt="Follow me on Twitter" title="Follow me on Twitter" /></a></div>
				<div class="linkedin"><a href="http://www.linkedin.com/pub/robin-hills/33/a32/ab5" title="Connect with me on LinkedIn"><img src="images/icon_linkedin.gif" title="Connect with me on LinkedIn" alt="Connect with me on LinkedIn" /></a></div>
				<div class="gplus"><a href="https://plus.google.com/116169936861129306953/posts" title="Hang with me on Google+"><img src="images/icon_gplus.gif" title="Hang with me on Google++" alt="Hang with me on Google+" /></a></div>
				<div class="clear"></div>
			</div>
			<div class="text"><?PHP echo $profile['intro'];?></div>
		</div>
			<?PHP
		}
		?>
		<div class="clear"></div>
		
		<?PHP
		if($profile !== false)
		{
			?>
		
			<div class="update">
				<div><span>The Latest</span></div> 
				<div><?PHP echo $profile['status']['text'];?></div>
				<div><?PHP echo date('Y-m-d H:i',$profile['status']['date']);?></div>
			</div>
			<?PHP
		}
		?>
	</div>
</div>
