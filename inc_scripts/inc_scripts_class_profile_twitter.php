<?PHP

/**
* Base include
*/
include_once(dirname(__FILE__).'/inc_scripts_class_profile.php');

!defined('TWITTER_API_BASE') ? define('TWITTER_API_BASE','https://api.twitter.com') : null;
!defined('TWITTER_STATUS_BASE') ? define('TWITTER_STATUS_BASE','https://twitter.com/#!/%s/status/%s') : null;

/**
* Twitter Profile class
*/
class Twitter extends Profile
{
	public function __construct($username = false)
	{
		parent::__construct();
		
		$this->setUsername($username);
		
	}
	
	public function profile()
	{
		
		parent::profile('twitter_profile');
		
		if($this->cache_data === false)
		{
			// Grab the users profile
			$content = @file_get_contents(TWITTER_API_BASE."/1/users/show.json?screen_name=".$this->username."&include_entities=true");
			
			if($content !== false)
			{
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
				$this->profile = false; // Error condition
			
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
				$cache = $this->retrieve('twitter_timeline');
			
			if(($cache === 0) || ($cache === false))
			{
				// Grab the users timeline
				$content = @file_get_contents(TWITTER_API_BASE."/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name=".$this->username."&count=".$count);
					
				if($content !== false)
				{
					$json = json_decode($content,true);
					
					if($json !== null)
					{
						foreach($json as $anUpdate)
						{
							$update = array(
												'text' => $anUpdate['text'],
												'id' => $anUpdate['id_str'],
												'date' => strtotime($anUpdate['created_at'])
											);
							
							// Make any links clickable
							if($this->convertLinks)
								$this->anchorLinks($update['text']);
							
							$updates[] = $update;
							unset($update);
						}
					}
					
					if($cache === 0)
						$this->cache('twitter_timeline',$updates);
				}
				else
					$updates = false;// Error state
			}
			else
				$updates = $cache;
		}
		
		return $updates;
		
	}
}
?>
