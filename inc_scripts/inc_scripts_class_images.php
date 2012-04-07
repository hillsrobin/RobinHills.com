<?PHP

include_once('../inc_scripts/inc_scripts_class_utils.php');

class Images extends SimpleMySQL
{
	private $id = false;
	private $user_id = -1;
	private $fields = array('owner','filename','caption');
	
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
		
		$this->Results = $this->QueryAsRow('SELECT * FROM images WHERE id='.$this->id);
		
		$this->isError = $this->Error();
	}
	
	public function All($filter = false)
	{
		if($filter !== false)
			$filter = 'WHERE '.$filter.' ';
		else
			$filter = '';
				
			
		
		$this->Results = $this->QueryAsArray(
												'SELECT images.*, users.firstName '.
												'FROM posts '.
												'LEFT JOIN users '.
												'ON users.id = images.owner '.
												$filter.
												'ORDER BY images.uploadDate DESC'
												);
		
		$this->isError = $this->Error();
	}
	
	public function Add($data)
	{
		// If the owner key is not set AND $this->user_id is not -1 inject it
		if((!isset($data['owner'])) && (intval($data['owner']) != -1))
			$data['owner'] = $this->user_id;
			
		$query = 'INSERT INTO images (';
		$values = ' VALUES (';
		
		foreach($data as $key => $item)
		{
			if(array_search($key,$this->fields) !== false)
			{
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
		$query = 'UPDATE images SET ';
		
		foreach($data as $key => $item)
		{
			if(array_search($key,$this->fields) !== false)
				$query .= $key.'="'.mysql_safe($item).'", ';
		}
		
		$query = rtrim($query,', ');
		$this->Query($query.' WHERE id='.$this->id);
		
		$this->isError = $this->Error();
		
	}
	
	public function Delete($id)
	{
		if($id !== false)
			$this->id = $id;
		
		$this->Query('DELETE FROM images WHERE id='.$this->id);
		$this->id = false;
	}
	
	public static function HandleUpload($field_name)
	{
		$filenames = array();
		
		// Determine if there is more than one image
		if(!is_array($_FILES[$field_name]['type'])) // If the type field is an array there are multiple images
		{
			// Rebuild the array as if there are multiple images
			$images = array($field_name => array(
								'name' => array($_FILES[$field_name]['name']),
								'type' => array($_FILES[$field_name]['type']),
								'tmp_name' => array($_FILES[$field_name]['tmp_name']),
								'error' => array($_FILES[$field_name]['error']),
								'size' => array($_FILES[$field_name]['size'])
								));
		}
		else
			$images &= $_FILES;
			
			
		for($i = 0; $i < count($images[$field_name]['type']); $i ++)
		{
			// Skip if there is some kind of error
			if($images[$field_name]['error'][$i] != UPLOAD_ERR_OK)
			{
				$filenames[] = -1;
				continue;
			}
			
			// Make sure the file is an image
			switch($images[$field_name]['type'][$i])
			{
				case 'image/jpeg':
				case 'image/pjpeg':
				case 'image/gif':
				case 'image/png':
					// All is good
					break;
				default:
					$filenames[] = -1;
					continue;
			}
			
			$filename = Utils::UniqueName($images[$field_name]['name'][$i]);
			
			if(move_uploaded_file($images[$field_name]['tmp_name'][$i],IMAGE_PATH.$filename))
				$filenames[] = $filename;
			else
				$filenames[] = -1;
		}
		
		return $filenames;
		
	}
}

?>
