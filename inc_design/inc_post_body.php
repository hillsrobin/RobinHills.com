<?PHP						
	$cats = $posts->Categories($post['categories']);
?>
<div class="post">
	<div class="date_bar">
		<div class="date"><?PHP echo date('l F d, Y',strtotime($post['postDate']));?></div>
		<?PHP
		if(is_numeric($_SESSION['User']))
		{
			?>
			<div class="post_options">
				<div class="icon"><a href="function.php?action=post_delete&id=<?PHP echo $post['id'];?>" title="Delete Post"><img src="images/icon_delete.gif" alt="Delete Post" title="Delete Post"/></a></div>
				<div class="icon"><a href="post.php?action=edit&id=<?PHP echo $post['id'];?>" title="Edit Post"><img src="images/icon_edit.gif" alt="Edit Post" title="Edit Post"/></a></div>
				<div class="status">Status: <?PHP echo ucfirst($post['status']);?></div>
				<div class="clear"></div>
			</div>
			<?PHP
		}
		?>
		<div class="clear"></div>
	</div>
	<div class="title"><?PHP
	if(!isset($_GET['action']))
	{
		?>
		<a href="<?PHP echo Posts::Url($post); ?>" title="<?PHP echo EncodeText($post['title']);?>"><?PHP echo EncodeText($post['title']);?></a>
		<?PHP
	}
	else
		echo EncodeText($post['title']);
	?>
	</div>
	<div class="body">
		<?PHP
		if(intval($post['image']) > 0)
		{
			?><div class="image"><img src="image.php?id=<?PHP echo $post['image'];?>&size=320x0" alt="" title=""/></div><?PHP
		}
		?>
		<?PHP echo Utils::nl2p($post['body'],false);?>
	</div>
							
	<?PHP 
	if(count($cats) > 0)
	{
		?>
		<div class="filed">Filed as <?PHP
							
		foreach($cats as $cat)
		{
			?><a href="/category_<?PHP echo str_replace('+','-',urlencode($cat));?>.html" title="<?PHP echo EncodeText($cat);?>"><?PHP echo EncodeText($cat);?></a> <?PHP
		}
		?>
		
		</div>
		<?PHP
	}
	?>
		<div class="posted">Posted at <?PHP echo date('H:i',strtotime($post['postDate']));?> by <?PHP echo $post['firstName'];?></div>
		<div class="clear"></div>
	</div>
