<?php
/**
 * 
 * Enter description here ...
 * @author user
 *
 */
class system_Image
{
    protected $image;
    public $extension;
    public $info;
    
	public function __construct($file)
	{
		if (!file_exists($file))
			return;

		$info = getimagesize($file);

		$this->info = array(
			'width'  => $info[0],
			'height' => $info[1],
			'bits'   => $info['bits'],
			'mime'   => $info['mime']
		);
		 
		$this->image = $this->create($file);
	}
	
	public function __destruct()
	{
		imagedestroy($this->image);
	}
		
	private function create($image)
	{
		switch ($this->info['mime']) {
			case 'image/gif':
				$this->extension = 'gif';
				return imagecreatefromgif($image);
			case 'image/png':
				$this->extension = 'png';
				return imagecreatefrompng($image);
			case 'image/jpeg':
				$this->extension = 'jpg';
				return imagecreatefromjpeg($image);
		}
    }

    public function save($file, $quality = 90)
    {
    	if (is_resource($this->image)) {
	    	switch ($this->info['mime']) {
	    		case 'image/gif':
	    			imagegif($this->image, $file);
	    			break;
	    		case 'image/png':
	    			imagepng($this->image, $file, 0);
	    			break;
	    		case 'image/jpeg':
	    			imagejpeg($this->image, $file, $quality);
	    			break;
	    	}
    	}
    }
    
    public function isImage()
    {
		if ($image->info['mime'] == 'image/jpeg' || $image->info['mime'] == 'image/png' 
			|| $image->info['mime'] == 'image/gif') {
			return 1;
		}
		
		return 0;
	}
    
    public function resize($width = 0, $height = 0) {
    	if (!$this->info['width'] || !$this->info['height']) {
    		return;
    	}
    
    	$xpos = 0;
    	$ypos = 0;
    
    	$scale = min($width / $this->info['width'], $height / $this->info['height']);
    
    	if ($scale == 1) {
    		return;
    	}
    
    	$new_width = (int)($this->info['width'] * $scale);
    	$new_height = (int)($this->info['height'] * $scale);
    	$xpos = (int)(($width - $new_width) / 2);
    	$ypos = (int)(($height - $new_height) / 2);
    
    	$image_old = $this->image;
    	$this->image = imagecreatetruecolor($width, $height);
    		
    	if (isset($this->info['mime']) && $this->info['mime'] == 'image/png') {
    		imagealphablending($this->image, false);
    		imagesavealpha($this->image, true);
    		$background = imagecolorallocatealpha($this->image, 255, 255, 255, 127);
    		imagecolortransparent($this->image, $background);
    	} else {
    		$background = imagecolorallocate($this->image, 255, 255, 255);
    	}
    
    	imagefilledrectangle($this->image, 0, 0, $width, $height, $background);
    
    	imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
    	imagedestroy($image_old);
    	 
    	$this->info['width']  = $width;
    	$this->info['height'] = $height;
    }
    
	public function watermark($file, $position = 'bottomright')
    {
        $watermark = imagecreatefrompng($file);
        
        $watermark_width = imagesx($watermark);
        $watermark_height = imagesy($watermark);
        
        switch($position) {
        	case 'center':
        		$watermark_pos_x = ($this->info['width'] - $watermark_width) / 2;
        		$watermark_pos_y = ($this->info['height'] - $watermark_height) / 2;
        		break;
            case 'topleft':
                $watermark_pos_x = 0;
                $watermark_pos_y = 0;
                break;
            case 'topright':
                $watermark_pos_x = $this->info['width'] - $watermark_width;
                $watermark_pos_y = 0;
                break;
            case 'bottomleft':
                $watermark_pos_x = 0;
                $watermark_pos_y = $this->info['height'] - $watermark_height;
                break;
            case 'bottomright':
                $watermark_pos_x = $this->info['width'] - $watermark_width;
                $watermark_pos_y = $this->info['height'] - $watermark_height;
                break;
        }
        
        imagecopy($this->image, $watermark, $watermark_pos_x, $watermark_pos_y, 0, 0, $watermark_width, $watermark_height);
        
        imagedestroy($watermark);
    }
    
    public function crop($top_x, $top_y, $bottom_x, $bottom_y, $width = 0, $height = 0)
    {
		if ($width == 0 || $height == 0) {
			$width = $bottom_x - $top_x;
			$height = $bottom_y - $top_y;
		}
		
		$scale = min($width / $this->info['width'], $height / $this->info['height']);
		
        $image_old = $this->image;
        $this->image = imagecreatetruecolor($width, $height);
        
        //imagecopyresampled($this->image, $image_old, 0, 0, $top_x, $top_y, $width, $height, $bottom_x - $top_x, $bottom_y - $top_y);
        imagecopyresampled($this->image, $image_old, 0, 0, $top_x, $top_y, $width, $height, $bottom_x - $top_x, $bottom_y - $top_y);
        imagedestroy($image_old);
        
        $this->info['width'] = $width;
        $this->info['height'] = $height;
    }
    
    public function resize_crop_center($width = 0, $height = 0)
    {
    	if ($width <= 0 || $height <= 0) {
    		return;
    	}
    	
    	$scale = $width / $height;
    	$scale_old = $this->info['width'] / $this->info['height'];
    	
    	
    	if ($scale > $scale_old) {
    		$scale_new = $this->info['width'] / $width; 
    		$pos_x = 0;
    		$pos_y = ($this->info['height'] - ($height * $scale_new)) / 2;
    	} else {
    		$scale_new = $this->info['height'] / $height;
    		$pos_x = ($this->info['width'] - ($width * $scale_new)) / 2;
    		$pos_y = 0;
    	}
    	
    	$image_old = $this->image;
    	$this->image = imagecreatetruecolor($width, $height);

    	imagecopyresampled($this->image, $image_old, 0, 0, $pos_x, $pos_y, $width, $height, $pos_x+($width*$scale_new), $pos_y+($height*$scale_new));
    	imagedestroy($image_old);
    
    	$this->info['width'] = $width;
    	$this->info['height'] = $height;
    }
    
    public function rotate($degree, $color = 'FFFFFF')
    {
		$rgb = $this->html2rgb($color);
		
        $this->image = imagerotate($this->image, $degree, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
        
		$this->info['width'] = imagesx($this->image);
		$this->info['height'] = imagesy($this->image);
    }
	    
    private function filter($filter)
    {
        imagefilter($this->image, $filter);
    }
            
    private function text($text, $x = 0, $y = 0, $size = 5, $color = '000000')
    {
		$rgb = $this->html2rgb($color);
        
		imagestring($this->image, $size, $x, $y, $text, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
    }
    
    private function merge($_file, $x = 0, $y = 0, $opacity = 100)
    {
        $merge = $this->create($_file);

        $mergeWidth = imagesx($image);
        $mergeHeight = imagesy($image);
		        
        imagecopymerge($this->image, $merge, $x, $y, 0, 0, $mergeWidth, $mergeHeight, $opacity);
    }
			
	private function html2rgb($color)
	{
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}
		
		if (strlen($color) == 6) {
			list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);   
		} elseif (strlen($color) == 3) {
			list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);    
		} else {
			return false;
		}
		
		$r = hexdec($r); 
		$g = hexdec($g); 
		$b = hexdec($b);    
		
		return array($r, $g, $b);
	}	
}

/* End of file .php */
