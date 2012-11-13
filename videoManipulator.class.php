<?php
class videoManipulator
{
	private $input_file;
	private $output_file;
	private $imgsrc_folder;
	private $vidsrc_folder;
	private $vidout_folder;
	private $src_images;
	private $error;
	
	function __construct($input_file,$output_file='out.mp4')
	{
		//config folders
		$this->imgsrc_folder='images.src';
		$this->vidsrc_folder='videos.src';
		$this->vidout_folder='videos.out';
		
		$this->input_file=$this->vidsrc_folder.'/'.$input_file;
		$this->output_file=$this->vidout_folder.'/'.$output_file;
		
		$this->src_images=array();
		
		if(!file_exists($this->input_file))
		{
			$this->error=true;	
			echo "File not found at ".$this->input_file;
		}
		
	}
	
	function decode()
	{
		if(!$this->error)
		{
			$input_file=$this->input_file;
			$imgsrc_folder=$this->imgsrc_folder;
			$query="ffmpeg -i $input_file -r 25 -f image2 $imgsrc_folder/image-%3d.jpeg >/dev/null 2>/dev/null &";
			shell_exec($query);
			$this->load_files();
		}
	}
	
	function encode()
	{
		if(!$this->error)
		{
			$vidout_folder=$this->vidout_folder;
			$imgsrc_folder=$this->imgsrc_folder;
			$output_file=$this->output_file;
			$query="ffmpeg -f image2 -r 25 -i $imgsrc_folder/image-%03d.jpeg  $output_file >/dev/null 2>/dev/null &";
			shell_exec($query);
			$this->clean_files();
		}
		
	}
	
	function clean_files()
	{
		foreach($this->src_images as $entry)
		{
			unlink($entry);
		}
	}
	
	function load_files()
	{	
		
		if ($handle = opendir($this->imgsrc_folder)) 
		{
			while (false !== ($entry = readdir($handle))) 
			{
				if ($entry != "." && $entry != "..") 
				{
					$this->src_images[]=$this->imgsrc_folder.'/'.$entry;
				}
			}
			closedir($handle);
		}
	}
	
	function add_filter($texto,$min_zoom,$max_zoom,$time_space)
	{
		$size=$min_zoom;
		$src_images=$this->src_images;
		foreach($src_images as $image)
		{
			$img=imagecreatefromjpeg($image);
			$black = imagecolorallocate($img, 0, 0, 0);
			imagettftext($img,$size,0,50,50,$black,"fonts/testfont.ttf",$texto);
			imagejpeg($img,$image);
			imagedestroy($img);
			if($size<$max_zoom){$size=$size+$time_space;}
		}
	}	
}
$vm=new videoManipulator('teste.mp4');
$vm->decode();
$vm->add_filter('Tiago',1,100,0.01);
$vm->encode();

?>


