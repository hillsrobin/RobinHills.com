<?PHP

class Utils
{
	public static function Redirect($url)
	{
		// var_dump(debug_backtrace());
		// die();
		if(!headers_sent())
			header('Location:'.$url);
		else
		{
			?>
			<script type="text/javascript">
				window.location = '<?PHP echo $url;?>';
			</script>
			<?PHP
			
			die();
		}
	}
	
	public static function nl2p($string, $line_breaks = true)
	{
		// Remove existing HTML formatting to avoid double-wrapping things
		$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);
		
		// It is conceivable that people might still want single line-breaks
		// without breaking into a new paragraph.
		if ($line_breaks == true)
			return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '<br />'), trim($string)).'</p>';
		else 
			return '<p>'.preg_replace("/([\n]{1,})/i", "</p>\n<p>", trim($string)).'</p>';
	}  
	
	public static function SimpleCipher($text)
	{
		$lookup_ = array(	'a' => 'n','b' => 'o','c' => 'p','d' => 'q','e' => 'r', 'f' => 's','g' => 't',
					'h' => 'u', 'i' => 'v', 'j' => 'w', 'k' => 'x','l' => 'y','m' => 'z','n' => 'a',
					'o' => 'b','p' => 'c','q' => 'd','r' => 'e','s' => 'f','t' => 'g','u' => 'h',
					'v' => 'i','w' => 'j','x' => 'k','y' => 'l','z' => 'm','0' => '5','1' => '6', 
					'2' => '7', '3' => '8', '4' => '9', '5' => '0', '6' => '1', '7' => '2', 
					'8' => '3','9' => '4','.' => '_', '_' => '.');
		
		for($i = 0; $i < strlen($text); $i ++)
		{
			if(isset($lookup_[$text[$i]]))
				$text[$i] = $lookup_[$text[$i]];
		}
		
		return $text;
	}
	
	public static function UniqueName($base)
	{
		$ext = substr($base, strripos($base,'.') + 1);
		$base = rtrim($base,$ext);
			
		$filename = preg_replace("/([^a-z,A-Z,_,0-9]+)/","",$base);
			
		if(strlen($filename) > 8)
			$filename = substr($filename,0,8);
			
		return $filename.date("ymdHis").'.'.$ext;
	}
}

?>
