<?PHP

	$script_name = pathinfo($_SERVER['SCRIPT_NAME'],PATHINFO_FILENAME);
	

	switch($script_name)
	{
		case 'login':
			$title_tag = 'Log In';
			break;
			
		case 'contact':
			$title_tag = 'Contact';
			break;
			
		case 'index':
			
			if(isset($_GET['category']))
				$title_tag = 'Category | '.str_replace('-',' ',$_GET['category']);
			else if(isset($_GET['archive']))
				$title_tag = 'Archive | '.date('F Y',strtotime($_GET['archive']));
			else
				$title_tag = 'Home';
			break;
			
		case 'post':
			if($_GET['action'] == 'add')
				$title_tag = 'Post an Entry';
			
			else if($_GET['action'] == 'edit')
			{
				$post_ = $post->Results;
				
				$title_tag = 'Edit Post | '.EncodeText($post_['title']);
			}
			
			else if($_GET['action'] == 'view')
				$title_tag = 'Post | '.EncodeText($post['title']);
			
			break;
		case 'resume':
			$title_tag = 'Resume';
			break;
			
		case 'portfolio':
			$title_tag = 'Portfolio';
			break;
	}
	
	if(trim($title_tag) != "")
		$title = ' - '.$title_tag;
	
	
?>
<title><?PHP echo HOST_TITLE.$title;?></title>
