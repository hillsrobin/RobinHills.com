<?PHP

/**
* Base include
*/
include_once(dirname(__FILE__).'/inc_scripts_class_profile.php');

!defined('DELICIOUS_API_BASE') ? define('DELICIOUS_API_BASE','http://feeds.delicious.com/v2/') : null;
!defined('DELICIOUS_TAG_BASE') ? define('DELICIOUS_TAG_BASE','http://delicious.com/%s/%s') : null;

/**
* Delicious Profile class
*/
class Delicious extends Profile
{
	
	
	public function __construct($username = false)
	{
		parent::__construct();
		
		$this->setUsername($username);
		
	}
	
	public function profile()
	{
		/*
		parent::profile('twitter_profile');
		
		if($this->cache_data === false)
		{
			// Grab the users profile
			$content = file_get_contents(TWITTER_API_BASE."/1/users/show.json?screen_name=".$this->username."&include_entities=true");
			
			$json = json_decode($content,true);
			
			if($json !== null)
			{
				$this->profile['intro'] = $json['description'];
				$this->profile['avatar'] = $json['profile_image_url'];
				$this->profile['status']['text'] = $json['status']['text'];
				$this->profile['status']['id'] = $json['status']['id_str'];
				$this->profile['status']['date'] = strtotime($json['status']['created_at']);
			}
		
			$this->cache('twitter_profile',$this->profile);
			
		}
		else
			$this->profile = $cache;
		
		// Make any links clickable
		if($this->convertLinks)
			$this->anchorLinks($this->profile['status']['text']);
		
		// Link the ... in truncated tweets to the status update
		if(preg_match("/\.\.\.$/",$this->profile['status']['text']) > 0)
		{
			$read_more_url = sprintf(TWITTER_STATUS_BASE,$username,$this->profile['status']['id']);
			$this->profile['status']['text'] = preg_replace("/\.\.\.$/","<a href=\"".$read_more_url."\" title=\"\">...</a>",$this->profile['status']['text']);
		}
		
		return $this->getProfile();
		*/
	}
	
	public function updates($count = 5)
	{
		// Validate count
		$count = intval($count);
		
		$updates = array();
		
		// Verify that something was defined and that it is less than 200 (API limit)
		if(($count != 0) && ($count <= 200))
		{
			$cache = false;
			if($this->useCache === true)
				$cache = $this->retrieve('delicious_updates');
			
			if(($cache === 0) || ($cache === false))
			{
				// Grab the users timeline
				$content = @file_get_contents(DELICIOUS_API_BASE."/json/".$this->username."?count=".$count);
				
				if($content !== false) // Ye be no error
				{
					
					$json = json_decode($content,true);
					
					if($json !== null)
					{
						foreach($json as $anUpdate)
						{
							
							$tags = '';
							$tags_url = '';
							if(is_array($anUpdate['t']) && count($anUpdate['t']) > 0)
							{
								$tags = implode(',',$anUpdate['t']);
								foreach($anUpdate['t'] as $tag)
									$tags_url .= '<a href="'.sprintf(DELICIOUS_TAG_BASE,$this->username,$tag).'" title="All '.$tag.' bookmarks">'.$tag.'</a>&nbsp;';
							}
							$update = array(
												'text' => $anUpdate['d'],
												'url' => $anUpdate['u'],
												'id' => 0,
												'date' => strtotime($anUpdate['dt']),
												'tags' => $tags,
												'tags_url' => $tags_url
											);
							
							
							
							$updates[] = $update;
							unset($update);
						}
					}
					
					if($cache === 0)
						$this->cache('delicious_updates',$updates);
				}
				else
					$updates = false;
			}
			else
				$updates = $cache;
		}
		
		return $updates;
		
	}
}
?>
