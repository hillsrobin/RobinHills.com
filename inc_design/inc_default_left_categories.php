<?PHP
	$cats = new Posts();
	$all_cats = $cats->AllCategories();
	if(count($all_cats) > 0)
	{
		?>
		<div class="box">
			<h3>Categories</h3>
			<div class="categories">
			<?PHP
			foreach($all_cats as $cat)
			{
				?><div class="category"><a href="/category_<?PHP echo str_replace('+','-',urlencode($cat));?>.html" title="<?PHP echo EncodeText($cat);?>"><?PHP echo EncodeText($cat);?></a></div><?PHP
			}
			?>
			</div>
		</div>
		<?PHP
	}
?>
