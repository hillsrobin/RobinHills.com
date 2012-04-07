<?PHP

class Download
{
	private $mime_type = "application/octet-stream";
	private $filepath = "";
	
	public function __construct($filepath = "",$mime_type = "")
	{
		if((trim($filepath) != "")&&(file_exists($filepath)))
		{
			$this->filepath = $filepath;
			
			if(trim($mime_type) != "")
				$this->mime_type = $mime_type;
			
			$this->SendHeaders();
		}
	}
	public function Send($filepath,$mime_type = "")
	{
		if((trim($filepath) != "")&&(file_exists($filepath)))
		{
			$this->filepath = $filepath;
			
			if(trim($mime_type) != "")
				$this->mime_type = $mime_type;
			
			$this->SendHeaders();
			
			return true;
		}
		else
			return false;
	}
	private function SendHeaders()
	{
		header("Content-type: ".$this->mime_type);
        header("Content-Disposition: attachment; filename=\"".basename($this->filepath)."\"");
        header("Content-Length: ".filesize($this->filepath));
        readfile($this->filepath, "r");
	}
}

?>
