<?PHP
	include('../inc_design/inc_default_origin.php');
//	include('../inc_scripts/inc_scripts_common_verify_locked.php');
	include('../inc_scripts/inc_scripts_class_posts.php');

	if((!isset($_GET['action'])) || (trim($_GET['action']) == ""))
		$_GET['action'] = 'view';
	
	switch(@$_GET['action'])
	{
		case 'view':
			$posts = new Posts($_GET['id']);
			$posts->Data();
			$post = $posts->Results;
			break;
			
		case 'edit':
			$post = new Posts($_GET['id']);
			$post->Data();
			break;
			
		case 'add':
			$postDate = date('Y-m-d H:i:s',time());
			break;
			
		default:
			break;
	}
	
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
			<div class="right">
				<?PHP
					include('../inc_design/inc_default_left_profile.php');
					include('../inc_design/inc_default_left_administration.php');
					include('../inc_design/inc_default_left_archives.php');
					include('../inc_design/inc_default_left_categories.php');
				?>
			</div>
			<div class="left">
				<?PHP	
				if($_GET['action'] != "view")	// Post administration
				{
					?>
				<div class="post_admin">
					<form id="post" action="function.php?action=post_<?PHP echo $_GET['action'];?><?PHP echo $_GET['action'] == 'edit' ? '&id='.$_GET['id'] : '';?>" method="post" enctype="multipart/form-data">
						<div class="element title">
							<div class="label"><label for="title">Title</label></div>
							<div class="field"><input type="text" name="title" id="title" value="<?PHP echo $post->Results['title'];?>"/></div>
							<div class="clear"></div>
						</div>
						<div class="element body">
							<div class="label"></div>
							<div class="field"><textarea name="body" id="body" rows="0" cols="0"><?PHP echo $post->Results['body'];?></textarea></div>
							<div class="clear"></div>
						</div>
						<div class="element image">
							<div class="label"><label for="image">Image</label></div>
							<div class="field">
								<?PHP
								if(($_GET['action'] == 'edit') && (intval($post->Results['image']) > 0))
								{
									?>
									<script type="text/javascript">
									window.addEvent('domready',function(){
										document.getElement('.image a').addEvent('click',function(){
											document.getElement('.image .field div').destroy();
											document.getElement('.image .field').set('html','<input type="file" name="image" id="image" value=""/>');
										});
									});
									</script>
									
									<div>
										<img src="image.php?id=<?PHP echo $post->Results['image'];?>&size=150x0" title="" alt="" />
										<a href="" title="" rel="action_link">Remove</a>
										<input type="hidden" name="image" value="<?PHP echo $post->Results['image'];?>"/>
									</div>
									<?PHP
								}
								else
								{
									?><input type="file" name="image" id="image" value=""/><?PHP
								}
								?>
							</div>
							<div class="clear"></div>
						</div>
						<div class="element categories">
							<div class="label"><label for="categories">Categories</label></div>
							<div class="field"><input type="text" name="categories" id="categories" value="<?PHP echo $post->Results['categories'];?>"/></div>
							<div class="clear"></div>
						</div>
						<?PHP
						if(count($all_cats) > 0)
						{
							?>
						<div class="element available_categories">
							<div class="label"></div>
							<div class="field">
								<script type="text/javascript">
								window.addEvent('domready',function(){
									var categories = document.getElements('.available_categories .acategory a');
									
									categories.each(function(item,index){
										item.addEvent('click',function(){
												
											// Check if the category already exists
											if(item.retrieve('selected').toInt() == 1)
											{
												$('categories').value = $('categories').value.replace(item.get('html'),"");
												
												//Clean up stray commas
												$('categories').value = $('categories').value.replace(/\,$/g,"");
												$('categories').value = $('categories').value.replace(/^\,/g,"");
												$('categories').value = $('categories').value.replace(/\,{2,20}/g,",");
											
												item.setStyle('text-decoration','none');
												
												item.store('selected',0);
											}
											else
											{
												if($('categories').value != '')
													$('categories').value += ',';
												
												$('categories').value += item.get('html');
												
												item.setStyle('text-decoration','underline');
												
												item.store('selected',1);
											}
										});
											
										item.removeProperty('href');
										item.setStyle('cursor','pointer');
										
										if($('categories').value.search(item.get("html")) == -1)
											item.store('selected',0);
										else
										{
											item.store('selected',1);
											item.setStyle('text-decoration','underline');
										}
											
																				
									});
								});
								</script>
								<?PHP
								foreach($all_cats as $category)
								{
									?><div class="acategory"><a href="" title=""><?PHP echo EncodeText($category);?></a></div><?PHP
								}
								?><div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						<?PHP
						}
						?>
						<div class="element status">
							<div class="label"><label for="tags">Status</label></div>
							<div class="field">
								<select name="status" id="status">
									<option value="active"<?PHP echo $post->Results['status'] == 'active' ? ' selected="selected"' : '';?>>Active</option>
									<option value="draft"<?PHP echo $post->Results['status'] == 'draft' ? ' selected="selected"' : '';?>>Draft</option>
									<option value="disabled"<?PHP echo $post->Results['status'] == 'disabled' ? ' selected="selected"' : '';?>>Disabled</option>
								</select>
							</div>
							<div class="clear"></div>
						</div>
						<div class="element postdate">
							<div class="label"><label for="postDate">Post Date</label></div>
							<div class="field">
								<div class="postdate_field"><input type="text" name="postDate" id="postDate" value="<?PHP echo $_GET['action'] == 'edit' ? $post->Results['postDate'] : $postDate ;?>"/></div>
								<div class="postdate_now_field"><input type="checkbox" id="postDate_now" name="postDate_now" /></div>
								<div class="postdate_now_label"><label for="postDate_now">Now</label></div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						<script type="text/javascript">
							window.addEvent('domready',function(){
									
									$('postDate_now').addEvent('change',function(){
											$('postDate').readOnly = $('postDate_now').checked;
									});

									
									
									
							});
						</script>
						<div class="element submit">
							<div class="label"></div>
							<div class="field"><input type="submit" id="submit" value="Submit" /></div>
							<div class="clear"></div>
						</div>
					</form>
				</div>
				<?PHP
				}
				else	// View a single post
				{
					if(!$posts->isError)
						include('../inc_design/inc_post_body.php');
					else
						echo "Post not found";
				}
				?>
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
