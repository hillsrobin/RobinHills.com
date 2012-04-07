<?PHP

// Image modification/display class
class Image
{
	private $image = '';		// image data
	private $temp = '';		// temp image
	private $type = '';		// image type
	
	function __construct($sourceFile)
	{
		if(file_exists($sourceFile))
		{
			$this->image = Image::imageLoad($sourceFile);
			$this->type = Image::imageType($sourceFile);
		}
		
		return;
	}
	
	function __destruct()
	{
	}
	
	static function imageShow($sourceFile)
	{
		$img = new imageMod($sourceFile);
		$img->show();
	}
	
	// determine the image type based on the file extension
	static function imageType($sourceFile)
	{
		$loc = strripos ($sourceFile,'.') + 1;
		return substr($sourceFile,$loc, strlen($sourceFile) - $loc);
	}
	
	// Load the image to memory
	static function imageLoad($sourceFile)
	{
		$image = false;
		
		if(file_exists($sourceFile))
		{
			// Determine the image type
			$type = Image::imageType($sourceFile);
			switch(strtolower($type))
			{
				case 'jpg':
				case 'jpeg':
					$image = imagecreatefromjpeg($sourceFile);
					break;
				case 'gif':
					$image = imagecreatefromgif($sourceFile);
					break;
				case 'png':
					$image = imagecreatefrompng($sourceFile);
					break;
				default:
					return false;
			}
		}
		
		return $image;
	}
	
	static function imageDimensions($sourceFile)
	{
		if(is_string($sourceFile))	// If variable is a string assume it is a file path
			$image = Image::imageLoad($sourceFile);
		else				// Otherwise treat it as an image data
			$image = $sourceFile;
		
		$dimensions['width'] = imagesx($image);	// Element 0 --> Image Width
		$dimensions['height'] = imagesy($image);	// Element 1 --> Image Height
		$dimensions[0] = $dimensions['width'];
		$dimensions[1] = $dimensions['height'];
		
		return $dimensions;
	}
	
	static function imageHeight($new_w,$new_h,$o_wd,$o_ht,$aspectratio = true)
	{
		$size = Image::imageSize($new_w,$new_h,$o_wd,$o_ht,$aspectratio);
		return $size['height'];
	}
	
	static function imageWidth($new_w,$new_h,$o_wd,$o_ht,$aspectratio = true)
	{
		$size = Image::imageSize($new_w,$new_h,$o_wd,$o_ht,$aspectratio);
		
		return $size['width'];
	}
	
	static function imageSize($new_w,$new_h,$o_wd,$o_ht,$aspectratio = true)
	{
		$aspect = false;	// default to NO aspect ratio
		
		if(($new_w <= 0) && ($new_h <= 0))
			return false;
		
		// Calculate based on the passed size so 
		// the side will fall into line (using aspect ratio)
		if($new_h <= 0)
			$new_h = round($o_ht * $new_w / $o_wd);
		else if($new_w <= 0)
			$new_w = round($o_wd * $new_h / $o_ht);
		else
			$aspect = $aspectratio;

		if($aspect) // Calculate proportion
		{
			$w = round($o_wd * $new_h / $o_ht);
			$h = round($o_ht * $new_w / $o_wd);
			
			if(($new_h-$h)<($new_w-$w))
				$new_w =& $w;
			else
				$new_h =& $h;
		}

		return array('width' => $new_w, 'height' => $new_h);
	}
	
	static function imageIptc($filename,$tagName = '__ALL__')
	{
		getimagesize($filename, $info);
		
		if (isset($info["APP13"])) 
			$iptc = iptcparse($info["APP13"]);
		
		$output = array();
		foreach($iptc as $tag => $data)
		{
			$tag = intval(str_replace('2#','',$tag));
			switch($tag) 
			{
				case 55:
					$sTag = 'reference_number';
					break;
				case 110:
					$sTag = 'credit';
					break;
				case 120:
					$sTag = 'caption';
					break;
				case 121:
					$sTag = 'local_caption';
					break;
				default:
					unset($sTag);
			}
			
			if($sTag != '')
				$output[$sTag] = $data[0];
		}
		
		if($tagName != '__ALL__')
		{
			if(isset($output[$tagName]))
				return $output[$tagName];
			else
				return false;
		}
		else
			return $output;
	}
	
	function fillSize($width,$height)
	{
		list($o_width, $o_height) = array_values(Image::imageDimensions($this->image));
		
		// calculate ratio of original images
		$o_ratio = $o_width/$o_height;
		
		// calculate ratio of destination size
		$ratio = $width/$height;
		 
		// If equal no fill required
		if($ratio == $o_ratio)
			$this->resize($width,$height,true);
		else
		{
			$palette = imagecreatetruecolor($width, $height);
			
			
			if($o_height > $o_width)
			{
				$this->resize(0,$height);
				$dst_x = ($width/2) - (imagesx($this->image) / 2);
				$dst_y = 0;
			}
			else
			{
				$this->resize($width,0);
				$dst_x = 0;
				$dst_y = ($height/2) - (imagesy($this->image) / 2);
			}
			
			imageCopyResampled($palette,$this->image,$dst_x,$dst_y,0,0,$width,$height,$width,$height);
			
			$this->temp =& $palette;
			unset($palette);
			$palette = '';
			
			$this->sync();
		}
		
	}
	
	// resize the current image loaded into memory
	function resize($width, $height, $aspectratio = true)
	{
		$aspect = false;	// default to NO aspect ratio
		
		if(($width <= 0) && ($height <= 0))
			return false;
		
		list($o_wd, $o_ht) = array_values(Image::imageDimensions($this->image));
		
		// Calculate based on the passed size so 
		// the side will fall into line (using aspect ratio)
		if($height <= 0)
			$height = round($o_ht * $width / $o_wd);
		else if($width <= 0)
			$width = round($o_wd * $height / $o_ht);
		else
			$aspect = $aspectratio;
			
		if($aspect) // Calculate proportion
		{
			$w = round($o_wd * $height / $o_ht);
			$h = round($o_ht * $width / $o_wd);
			
			if(($height-$h)<($width-$w))
				$width =& $w;
			else
				$height =& $h;
		}
		
		$this->temp = imageCreateTrueColor($width,$height);
		
		if(($this->type == 'gif')||($this->type == 'png'))
		{
			imagealphablending($this->temp, false);
			imagesavealpha($this->temp,true);
			$transparent = imagecolorallocatealpha($this->temp, 255, 255, 255, 127);
			imagefilledrectangle($this->temp, 0, 0, $width, $height, $transparent);
		}
		
		imageCopyResampled($this->temp, $this->image,0, 0, 0, 0, $width, $height, $o_wd, $o_ht);
		
		$this->sync();
		
		
		
		return true;
	}
	
	function sync(){
		$this->image =& $this->temp;
		unset($this->temp);
		$this->temp = '';
		return;
	}
	
	function show($type = '__DEFAULT__'){
		
		if($type != '__DEFAULT__')
			$this->type = $type;
		
		$this->_sendHeader();
		
		switch(strtolower($this->type))
		{
			case 'jpg':
			case 'jpeg':
				imagejpeg($this->image);
				break;
			case 'gif':
				imagegif($this->image);
				break;
			case 'png':
				imagepng($this->image);
				break;
			default:
				return false;
		}
				
		return;
	}
	
	function _sendHeader(){
		
		switch(strtolower($this->type))
		{
			case 'jpg':
			case 'jpeg':
				header('Content-Type: image/jpeg');
				break;
			case 'gif':
				header('Content-Type: image/gif');
				break;
			case 'png':
				header('Content-Type: image/x-png');
				break;
			default:
				return false;
		}
		
		
	}
	
	function store($file, $quality = 100)
	{
		switch(strtolower($this->type))
		{
			case 'jpg':
			case 'jpeg':
				return imagejpeg($this->image,$file,$quality);
				break;
			case 'gif':
				return imagegif($this->image,$file,$quality);
				break;
			case 'png':
				return imagepng($this->image,$file,$quality);
				break;
			default:
				return false;
				//	die('img_manip::store --> invalid type');
		}
	
		return;
	}
	
	function watermark($pngImage, $left = 0, $top = 0)
	{
		ImageAlphaBlending($this->image, true);
		$layer = ImageCreateFromPNG($pngImage); 
		$logoW = ImageSX($layer); 
		$logoH = ImageSY($layer); 
		ImageCopy($this->image, $layer, $left, $top, 0, 0, $logoW, $logoH); 
	}
}
?>