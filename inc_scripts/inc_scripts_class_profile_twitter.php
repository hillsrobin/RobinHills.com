<?PHP

/**
* Base include
*/
include_once(dirname(__FILE__).'/inc_scripts_class_profile.php');

!defined('TWITTER_API_BASE') ? define('TWITTER_API_BASE','https://api.twitter.com') : null;

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
		
		if($this->convertLinks)
			$this->anchorLinks($this->profile['status']['text']);
		
		return $this->getProfile();
	}
}
?>
