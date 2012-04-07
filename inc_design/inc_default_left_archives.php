<?PHP
	$archives = new Posts();
	$all_archives = $archives->AllArchives();
	
	if(count($all_archives) > 0)
	{
		?>
		<div class="box">
			<h3>Archives</h3>
			<div class="archives">
			<?PHP
			foreach($all_archives as $key => $archive)
			{
				?><div class="archive"><a href="/archive_<?PHP echo $key;?>-01.html" title="<?PHP echo $archive;?>"><?PHP echo $archive;?></a></div><?PHP
			}
			?>
			</div>
		</div>
		<?PHP
	}
?>
