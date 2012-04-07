<?PHP

class Posts extends SimpleMySQL
{
	private $id = false;
	public $Results = array();
	public $isError = false;
	private $fields = array('title','body','categories','tags','postDate','image','user_id','status');
	private $user_id = -1;
	
	public function __construct($id = false)
	{
		global $db_profile;
		
		@session_start();
		
		if(is_numeric($_SESSION['User']))
			$this->user_id = $_SESSION['User'];
		
		parent::__construct($db_profile);
						
		if($id !== false)
			$this->id = $id;
	}
	
	public function __destruct()
	{
		parent::__destruct();
	}
	
	public function Data($id = false)
	{
		if($id !== false)
			$this->id = $id;
		
		$this->Results = $this->QueryAsRow('SELECT * FROM posts WHERE id='.$this->id);
		
		$this->isError = $this->Error();
	}
	
	public function All($filter = false)
	{
		if($filter !== false)
			$filter = 'WHERE '.$filter.' ';
		else
			$filter = '';
		
		if($this->user_id == -1)
		{
			if($filter != '')
				$filter .= ' AND status = "active" ';
			else 
				$filter = 'WHERE status = "active" ';
		}
		
			
		
		$this->Results = $this->QueryAsArray(
												'SELECT posts.*, users.firstName '.
												'FROM posts '.
												'LEFT JOIN users '.
												'ON users.id = posts.user_id '.
												$filter.
												'ORDER BY postDate DESC'
												);
		
		$this->isError = $this->Error();
	}
	
	public function byTag($tag)
	{
		$this->All("FIND_IN_SET('".mysql_safe($tag)."',tags)");
	}
	
	public function byCategory($category)
	{
		$this->All("FIND_IN_SET('".mysql_safe($category)."',categories)");
	}

	public function byMonth($date)
	{
		$date = date('Y-m',strtotime($date));
		$this->All("DATE_FORMAT(postDate, '%Y-%m') = '".$date."'");
	}
	
	public function AllCategories()
	{
		if($this->user_id == -1)
			$filter = 'WHERE status = "active" ';
		
		$res = $this->QueryAsArray('SELECT categories FROM posts '.$filter.'GROUP BY categories');
		
		$temp = array();
		$categories = array();
		
		if($this->Error())
			return $temp;
		
		foreach($res as $row)
			$temp = array_merge($temp,$this->Categories($row['categories']));
		
		foreach($temp as $row)
		{
			if(array_search(strtolower($row),$categories) === false)
				$categories[] = $row;
		}
		
		natcasesort($categories);
		
		return $categories;
	}
	
	public function AllArchives()
	{
		if($this->user_id == -1)
			$filter = 'WHERE status = "active" ';
		
		$res = $this->QueryAsArray(
									"SELECT DATE_FORMAT(postDate,'%Y-%m') AS date_key, ".
									"DATE_FORMAT(postDate,'%M %Y') AS date_desc ".
									"FROM posts ".
									$filter.
									"GROUP BY date_key ".
									"ORDER BY date_key DESC"
									);
		
		$archives = array();
		
		if($this->Error())
			return $archives;
		
		foreach($res as $row)
			$archives[$row['date_key']] = $row['date_desc'];
		
		return $archives;
	}
	
	public function Tags($tags = false)
	{
		if($tags === false)
		{
			if(isset($this->Results['tags']))
				$tags = $this->Results['tags'];
			else
				return false;
		}
		
		return $this->_parse_tags($tags);
	}
	
	public function Categories($categories = false)
	{
		if($categories === false)
		{
			if(isset($this->Results['categories']))
				$categories = $this->Results['categories'];
			else
				return false;
		}
		
		return $this->_parse_tags($categories);
	}
	
	private function _parse_tags($tags)
	{
		$tags = explode(',',$tags);
		
		$temp = array();
		
		for($i = 0; $i < count($tags); $i++)
		{
			if(trim($tags[$i]) != '')
				$temp[] = trim($tags[$i]);
		}
		
		return $temp;
	}
	
	public function Add($data)
	{
		$query = 'INSERT INTO posts (';
		$values = ' VALUES (';
		
		foreach($data as $key => $item)
		{
			if(array_search($key,$this->fields) !== false)
			{
				switch($key)
				{
					case 'tags':
					case 'categories':
						$item = preg_replace("/( *)?,( *)?/",",",$item);
						break;
				}
				
				$query .= $key.',';
				$values .= '"'.mysql_safe($item).'", ';
			}
		}
		
		$query = rtrim($query,',');
		$values = rtrim($values,', ');
		
		$query = $query.')'.$values.')';
				
		$this->Query($query);
		
		$this->isError = $this->Error();
		
		return $this->LastId();
	}
	
	public function Update($data)
	{
		$query = 'UPDATE posts SET ';
		
		foreach($data as $key => $item)
		{
			if(array_search($key,$this->fields) !== false)
			{
				switch($key)
				{
					case 'tags':
					case 'categories':
						$item = preg_replace("/( *)?,( *)?/",",",$item);
						break;
				}
				
				$query .= $key.'="'.mysql_safe($item).'", ';
			}
		}
		
		$query = rtrim($query,', ');
		$this->Query($query.' WHERE id='.$this->id);
		
		$this->isError = $this->Error();
		
	}
	
	public function Delete()
	{
		$this->Query('DELETE FROM posts WHERE id='.$this->id);
		$this->id = false;
	}
	
	public static function Url($post)
	{
		$url = str_replace(array(" ",","),"-",strtolower($post['categories']));
				
		$url_title = preg_replace("/[^0-9,a-z, ,\-]+/","",strtolower($post['title']));
		$url_title = preg_replace("/[ ]{1,20}/"," ",$url_title);
		$url_title = str_replace(" ","-",$url_title);
		
		$url = strlen($url) > 0 ? $url . "-" : "";
		
		$url .= $url_title."-idQ".$post['id'];
		
		return $url;
		
	}
}

?>
