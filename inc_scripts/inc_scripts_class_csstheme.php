<?PHP

class CSSTheme
{
	private $currentTheme = 'default';
	public $UseCookie = false;
	public $CookieName = 'theme';
	public $ThemePath = '';
	
	
	public function __construct($themeName = false)
	{
		if($themeName !== false)
			$this->setName($themeName);
	}
	
	public function __destruct()
	{
	
	}
	
	private function __valid($themeName = false)
	{
		if($themeName === false)
			$themeName = $this->currentTheme;
		
		if(file_exists($this->ThemePath.$themeName.".css"))
			return true;
		else
			return false;
	}
	
	private function __cleanName($themeName)
	{
		$themeName = preg_replace("/[^a-z,_]+/","",$themeName);
		
		return $themeName;
	}
	
	public function setName($themeName)
	{
		$themeName = $this->__cleanName($themeName);
		
		if($this->__valid($themeName))
			$this->currentTheme = $themeName;
	}
		
	
	public function getName()
	{
		$theme = "";
		
		
		if($this->UseCookie)
		{
		
			if(isset($_COOKIE[$this->CookieName]))
			{
				$theme = $this->__cleanName($_COOKIE[$this->CookieName]);
				
				if(!$this->__valid($theme))
					$theme = "";
			}
			else if((date("H") >= 20) || (date("H") <= 5))
				$theme = "moon";
			
			if(trim($theme) == "")
				$theme = "default";
			
			$this->currentTheme = $theme;
		}
		else
			$theme = $this->currentTheme;
			
		return $theme;
	}
	
	public function getText()
	{
		$text = "";
		
		if($this->__valid())
		{
			$hFile = fopen($this->ThemePath.$this->currentTheme.".css","r");
			
			if(($hFile !== false)&&(filesize($this->ThemePath.$this->currentTheme.".css") > 0))
			{
				
				// The description appears on the first line as a comment
				$line = fgets($hFile);
				
				$text = trim(str_replace(array("/**","**/"),"",$line));
			}
			
			@fclose($hFile);
		}
		
		return $text;
	}
	
	public function setCookie()
	{
		if(($this->useCookie) && ($this->__valid()))
			setcookie($this->CookieName,$this->getName(), time() + 315360000 /*10 years*/ , "/",COOKIE_DOMAIN);
	}
	
	public function getJavascript()
	{
		return "<script type=\"text/javascript\" src=\"javascript/jquery.cookie.js\"></script>
				<script type=\"text/javascript\">
				jQuery(document).ready(function(){
					var anchors = $('a[rel=csstheme]');
					
					anchors.each(function(index,item){
						item = $(item);
						var theme = item.attr('name');
						
						item.click(function(){
							$.cookie('".$this->CookieName."',theme, {duration: 365, path: '/', domain: '".COOKIE_DOMAIN."'});
							window.location.href = window.location.href;
						});
						
						item.attr('title','Switch to '+item.html());
						
					});
				});
			</script>
			";
			
	}
}

?>
