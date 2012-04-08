<?PHP

define('MYSQL_TOOLS_EMPTY', 15001);
define('MYSQL_TOOLS_ERROR', 15002);
define('MYSQL_TOOLS_UPDATE', 15003);

define('ENTITIES_ENCODED', 19001);

class SimpleMySQL
{
	private $data = array();
	private $log = array();
	private $debug = array();
	private $link = false;
	
	public function __construct($profile = null)
	{
		if($profile != null)
			$this->Connect($profile);
	}
	
	public function __destruct()
	{
		if($this->link !== false)
			@mysql_close($this->link);
	}
	
	public static function IsError($data)
	{
		$obj = new SimpleMySQL();
		
		$result = $obj->Error($data);
		
		unset($obj);
		
		return $result;
	}
	
	public function Error($data = false)
	{
		if($data === false)
			$data = $this->data;
		
		if(!is_numeric($data))
			return false;
	
		switch($data)
		{
			case MYSQL_TOOLS_EMPTY:
			case MYSQL_TOOLS_ERROR:
			case MYSQL_TOOLS_UPDATE:
				return true;
				break;
			default:
				return false;
		}
	}
	
	public function Log()
	{
		return $this->log;
	}
	
	public function Debug()
	{
		return $this->debug;
	}
	
	public function Connect($profile)
	{
		$this->link = mysql_connect($profile['host'],$profile['username'],$profile['password']);
		
		if($this->link === false)
			return false;
		
		if(isset($profile['database']))
			return $this->Database($profile['database']);
		else
			return true;
	}
	
	public function Database($dbName)
	{
		return mysql_select_db($dbName,$this->link);
	}
	
	public function QueryAsArray($query,$useEntities = 0)
	{
		return $this->Query($query,array('entities' => $useEntities));
	}
	
	public function QueryAsRow($query,$useEntities = 0)
	{
		return $this->Query($query,array('first' => 'true','entities' => $useEntities));
	}
	
	public function QueryAsXml($query, $useEntities = 0)
	{
		return $this->Query($query,array('as_xml' => 'true','entities' => $useEntities));
	}
	
	public function LastId()
	{
		$last_id = $this->QueryAsRow('SELECT LAST_INSERT_ID() AS id');
		return ($last_id['id']);
	}
	
	public function RowsAffected()
	{
		return mysql_affected_rows();
	}
	
	public function Query($query,$modifier = null)
	{
		$this->data = $this->_query($query,$modifier);
		return $this->data;
	}
	private function _query($query, $modifier = null)
	{
		$xml_output = '';
		$resQuery = mysql_query($query) or $this->log[] = array('query' => $query, 'error' => mysql_error());
		
		if(MODE_DEV) // Only dev debug
			$this->debug[] = $query;
		
		$arrayResults = array();
		
		if($resQuery == FALSE)	// Query Error (invaild resource)
			return MYSQL_TOOLS_ERROR;
	
		$query_type = strtoupper(substr($query,0,strpos($query,' ')));	// determine the query type (first word in the query)
		
		switch($query_type)
		{
			case 'UPDATE':
			case 'DELETE':
			case 'INSERT':
			case 'TRUNCATE':
				return MYSQL_TOOLS_UPDATE; 
				break;
			case 'SELECT':
				if(mysql_num_rows($resQuery) < 1)
					return MYSQL_TOOLS_EMPTY;
				break;
		}
		
		if(@$modifier['first'])
		{
			$row = mysql_fetch_array($resQuery,MYSQL_ASSOC);
				
			foreach($row as $key => $item)
				$row[$key] = mysql_unsafe($item);
				
			return $row;
		}
			
		if(@$modifier['as_xml'])
			$xml_output = '<results>';
			
		while($row = mysql_fetch_array($resQuery,MYSQL_ASSOC))
		{
			if(@$modifier['as_xml'])
			{
				$xml_output .= '<row>';
					
				foreach($row as $key => $item)
					$xml_output .= '<'.$key.'>'.domfriendly(mysql_unsafe($item,$modifier['entities'])).'</'.$key.'>';
					
				$xml_output .= '</row>';
			}
			else
			{
				foreach($row as $key=>$item)
					$row[$key] = mysql_unsafe($item,$modifier['entities']);
						
				array_push($arrayResults,$row);
			}
		}
			
		if(@$modifier['as_xml'])
		{
			$xml_output .= '</results>';
			$arrayResults = $xml_output;
		}
		
		return($arrayResults);
	}
	
	
}

function _array_one($array_data,$byField)
{
	$result = array();
	
	foreach($array_data as $item)
		$result[] = $item[$byField];
	
	if(count($result) > 0)
		return $result;
	else
		return false;
}

function _array_xml($array_data,$extra_data = null)
{
	$xml_output = '<results>';
	
	if(!SimpleMySQL::IsError($array_data))
	{
		foreach($array_data as $row)
		{
			$xml_output .= '<row>';
					
			foreach($row as $key => $item)
					$xml_output .= '<'.$key.'>'.domfriendly($item).'</'.$key.'>';
					
			$xml_output .= '</row>';
		}
	}
	
	if($extra_data != null)
	{
		$xml_output .= '<row>';
		
		foreach($extra_data as $key => $item)
			$xml_output .= '<'.$key.'>'.domfriendly($item).'</'.$key.'>';
		
		$xml_output .= '</row>';
	}
	
	$xml_output .= '</results>';
	
	return($xml_output);
}

function _array_csv($array_data)
{
	$output = "";
	
	if(!SimpleMySQL::IsError($array_data))
	{
		// Headers on the First Line
		$titles = array_slice($array_data,0,1);
		$titles = array_keys($titles[0]);
		
		foreach($titles as $title)
			$output .= '"'.str_replace("_"," ",$title).'",';
		
		$output = rtrim($output,',');
		$output .= "\r\n";
		
		foreach($array_data as $row)
		{
			foreach($row as $key => $item)
				$output .= '"'.DecodeText($item).'",';
			
			$output = rtrim($output,',');
			$output .= "\r\n";
		}
	}
	
	return($output);
}

function decodeVars($data, $sql_safe = true)
{
	$data = urldecode($data);
	
	if($sql_safe == true)
		$data = mysql_safe($data);
	
	if($sql_safe == ENTITIES_ENCODED)
		$data = EncodeText($data);
	
	return $data;
}

function mysql_unsafe($data, $useEntities = 0)
{
	$data = stripslashes($data);
	
	if($useEntities == 0)
		$data = htmlspecialchars_decode($data);
	
	return($data);
}
function mysql_safe($data, $useEntities = 0)
{
	// Remove null character
	$data = str_replace("\0","",$data);
	
	if($useEntities == 0)
		$data = htmlspecialchars($data);
	
	$data = addslashes($data);
	
	return $data;
}

function EncodeText($data)
{
	$data = htmlentities($data,ENT_QUOTES,'UTF-8');
	$data = str_replace('\'','&#39;',$data);
	return $data;
}

function DecodeText($data)
{
	return html_entity_decode($data,ENT_QUOTES,'UTF-8');
}

function namedToNumericEnities($data)
{
	$entities = array(
				'&iexcl;'=>'&#161;', '&curren;'=>'&#164;', '&cent;'=>'&#162;', '&pound;'=>'&#163;', '&yen;'=>'&#165;', '&brvbar;'=>'&#166;',
				'&sect;'=>'&#167;', '&uml;'=>'&#168;', '&copy;'=>'&#169;', '&ordf;'=>'&#170;', '&laquo;'=>'&#171;', '&not;'=>'&#172;',
				'&shy;'=>'&#173;', '&reg;'=>'&#174;', '&trade;'=>'&#8482;', '&macr;'=>'&#175;', '&deg;'=>'&#176;', '&plusmn;'=>'&#177;',
				'&sup2;'=>'&#178;', '&sup3;'=>'&#179;', '&acute;'=>'&#180;', '&micro;'=>'&#181;', '&para;'=>'&#182;', '&middot;'=>'&#183;',
				'&cedil;'=>'&#184;', '&sup1;'=>'&#185;', '&ordm;'=>'&#186;', '&raquo;'=>'&#187;', '&frac14;'=>'&#188;', '&frac12;'=>'&#189;',
				'&frac34;'=>'&#190;', '&iquest;'=>'&#191;', '&times;'=>'&#215;', '&divide;'=>'&#247;', '&Agrave;'=>'&#192;', '&Aacute;'=>'&#193;',
				'&Acirc;'=>'&#194;', '&Atilde;'=>'&#195;', '&Auml;'=>'&#196;', '&Aring;'=>'&#197;', '&AElig;'=>'&#198;', '&Ccedil;'=>'&#199;',
				'&Egrave;'=>'&#200;', '&Eacute;'=>'&#201;', '&Ecirc;'=>'&#202;', '&Euml;'=>'&#203;', '&Igrave;'=>'&#204;', '&Iacute;'=>'&#205;',
				'&Icirc;'=>'&#206;', '&Iuml;'=>'&#207;', '&ETH;'=>'&#208;', '&Ntilde;'=>'&#209;', '&Ograve;'=>'&#210;', '&Oacute;'=>'&#211;',
				'&Ocirc;'=>'&#212;', '&Otilde;'=>'&#213;', '&Ouml;'=>'&#214;', '&Oslash;'=>'&#216;', '&Ugrave;'=>'&#217;', '&Uacute;'=>'&#218;',
				'&Ucirc;'=>'&#219;', '&Uuml;'=>'&#220;', '&Yacute;'=>'&#221;', '&THORN;'=>'&#222;', '&szlig;'=>'&#223;', '&agrave;'=>'&#224;',
				'&aacute;'=>'&#225;', '&acirc;'=>'&#226;', '&atilde;'=>'&#227;', '&auml;'=>'&#228;', '&aring;'=>'&#229;', '&aelig;'=>'&#230;',
				'&ccedil;'=>'&#231;', '&egrave;'=>'&#232;', '&eacute;'=>'&#233;', '&ecirc;'=>'&#234;', '&euml;'=>'&#235;', '&igrave;'=>'&#236;',
				'&iacute;'=>'&#237;', '&icirc;'=>'&#238;', '&iuml;'=>'&#239;', '&eth;'=>'&#240;', '&ntilde;'=>'&#241;', '&ograve;'=>'&#242;',
				'&oacute;'=>'&#243;', '&ocirc;'=>'&#244;', '&otilde;'=>'&#245;', '&ouml;'=>'&#246;', '&oslash;'=>'&#248;', '&ugrave;'=>'&#249;',
				'&uacute;'=>'&#250;', '&ucirc;'=>'&#251;', '&uuml;'=>'&#252;', '&yacute;'=>'&#253;', '&thorn;'=>'&#254;', '&yuml;'=>'&#255;',
				'&OElig;'=>'&#338;', '&oelig;'=>'&#339;', '&Scaron;'=>'&#352;', '&scaron;'=>'&#353;', '&Yuml;'=>'&#376;', '&circ;'=>'&#710;',
				'&tilde;'=>'&#732;', '&ensp;'=>'&#8194;', '&emsp;'=>'&#8195;', '&thinsp;'=>'&#8201;', '&zwnj;'=>'&#8204;', '&zwj;'=>'&#8205;',
				'&lrm;'=>'&#8206;', '&rlm;'=>'&#8207;', '&ndash;'=>'&#8211;', '&mdash;'=>'&#8212;', '&lsquo;'=>'&#8216;', '&rsquo;'=>'&#8217;',
				'&sbquo;'=>'&#8218;', '&ldquo;'=>'&#8220;', '&rdquo;'=>'&#8221;', '&bdquo;'=>'&#8222;', '&dagger;'=>'&#8224;', '&Dagger;'=>'&#8225;',
				'&hellip;'=>'&#8230;', '&permil;'=>'&#8240;', '&lsaquo;'=>'&#8249;', '&rsaquo;'=>'&#8250;', '&euro;'=>'&#8364;', '&nbsp;'=>' ', '&apos;'=>'&#39;'
				);
	
	foreach($entities as $named => $numeric)
		$data = str_replace($named,$numeric,$data);
	
	return $data;
}

function domfriendly($data)
{
	$data = str_replace('&amp;','&',$data); // Get rid of the crazy double &amp;
	$data = str_replace('&','&amp;',$data);
	$data = str_replace('œ','oe',$data);
		
	$data = str_replace("\x95","&#149;",$data);
	$data = str_replace('™','&#153;',$data);
	$data = str_replace('¢','&#162;',$data);
	$data = str_replace('£','&#163;',$data);
	$data = str_replace('¼','&#188;',$data);
	$data = str_replace('½','&#189;',$data);
	$data = str_replace('¾','&#190;',$data);
	$data = str_replace('¿','&#191;',$data);
	$data = str_replace('Â','',$data);
	$data = str_replace('Ç','&#199;',$data);
	$data = str_replace('È','&#200;',$data);
	$data = str_replace('É','&#201;',$data);
	$data = str_replace('Ê','&#202;',$data);
	$data = str_replace('Î','&#206;',$data);
	$data = str_replace('Ò','&#210;',$data);
	$data = str_replace('Ó','&#211;',$data);
	$data = str_replace('Ô','&#212;',$data);
	$data = str_replace('Õ','&#213;',$data);
	$data = str_replace('Ù','&#217;',$data);
	$data = str_replace('Ú','&#218;',$data);
	$data = str_replace('Û','&#219;',$data);
	$data = str_replace('à','&#224;',$data);
	$data = str_replace('á','&#225;',$data);
	$data = str_replace('â','&#226;',$data);
	$data = str_replace('ã','&#227;',$data);
	$data = str_replace('ä','&#228;',$data);
	$data = str_replace('ç','&#231;',$data);
	$data = str_replace('è','&#232;',$data);
	$data = str_replace('é','&#233;',$data);
	$data = str_replace('ê','&#234;',$data);
	$data = str_replace('ë','&#235;',$data);
	$data = str_replace('î','&#238;',$data);
	$data = str_replace('ï','&#239;',$data);
	$data = str_replace('ñ','&#241;',$data);
	$data = str_replace('ò','&#242;',$data);
	$data = str_replace('ö','&#246;',$data);
	$data = str_replace('ó','&#243;',$data);
	$data = str_replace('ô','&#244;',$data);
	$data = str_replace('õ','&#245;',$data);
	$data = str_replace('ù','&#249;',$data);
	$data = str_replace('ú','&#250;',$data);
	$data = str_replace('û','&#251;',$data);
	$data = str_replace('ü','&#252;',$data);
	$data = str_replace('…','',$data);
	$data = str_replace("\x85",'',$data);
	$data = str_replace("\x0",'',$data);
	$data = str_replace("\0",'',$data);
	$data = str_replace('’','\'', $data);
	$data = str_replace('‘','\'', $data);
	$data = str_replace('“','\"', $data);
	$data = str_replace('”','\"', $data);
		
	$data = str_replace('–','-',$data);
	$data = str_replace('—','-',$data);
	$data = str_replace('·','',$data);
	
	return ($data);
}
?>
