<?PHP

/*
* Profile base class
*/

!defined('PROFILE_CACHE_PATH') ? define('PROFILE_CACHE_PATH','/tmp/') : null;
!defined('PROFILE_CACHE_TTL') ? define('PROFILE_CACHE_TTL',5) : null;

class Profile
{
	protected $profile = array();
	
	public $useCache = false;
	
	public $convertLinks = true;
	
	function __construct()
	{
	
	}
	
	public function getProfile()
	{
		if(is_array($this->profile)&&(count($this->profile) > 0))
			return $this->profile;
		else
			return false;
	}
	
	protected function cache($key,$value)
	{
		if(PROFILE_CACHE_TTL == 0)
			return false;
		
		if(is_writable(PROFILE_CACHE_PATH))
		{
			$data = json_encode(
						array(
							'data' => $value,
							'time' => time()
							)
			
						);
			$file = "profile_".sha1($key);
			
			file_put_contents(PROFILE_CACHE_PATH.$file,$data);
			
			return 1;
		}
		else
			return false;
	}
	
	protected function retrieve($key)
	{
		if(PROFILE_CACHE_TTL == 0)
			return false;
		
		$file = "profile_".sha1($key);
		
		if(file_exists(PROFILE_CACHE_PATH.$file))
		{
			$data = file_get_contents(PROFILE_CACHE_PATH.$file);
			
			$data = json_decode($data,true);
			
			if($data !== null)
			{
				if(((time() - intval($data['time'])) / 60) < PROFILE_CACHE_TTL)
					return $data['data'];
				else 
					return 0;
			}
			else
				return false;
		}
		else
			return 0;
	}
	
	protected function anchorLinks(&$text)
	{
		$text = preg_replace( "/((http|ftp)+(s)?:\/\/[^<>\s]+)/i", "<a href=\"\\0\" >\\0</a>",$text);
		
		return $text;
	}
}

?>
