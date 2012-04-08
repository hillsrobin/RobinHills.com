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
	function __construct()
	{
		parent::__construct();
	}
	
	function profile($username)
	{
		$cache = false;
		if($this->useCache === true)
			$cache = $this->retrieve('twitter_profile');
		
		if(($cache === 0) || ($cache === false))
		{
			// Grab the users profile
			$content = file_get_contents(TWITTER_API_BASE."/1/users/show.json?screen_name=".$username."&include_entities=true");
			
			$json = json_decode($content,true);
			
			if($json !== null)
			{
				$this->profile['intro'] = $json['description'];
				$this->profile['avatar'] = $json['profile_image_url'];
				$this->profile['status']['text'] = $json['status']['text'];
				$this->profile['status']['id'] = $json['status']['id_str'];
				$this->profile['status']['date'] = strtotime($json['status']['created_at']);
			}
			
			if($cache === 0)
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
	}
}
?>
