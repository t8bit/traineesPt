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
	private $id;
	
	function __construct($id,$input_file,$output_file='out.mp4')
	{
		//config folders
		$this->id=$id;
		$this->imgsrc_folder='images.src';
		$this->vidsrc_folder='videos.src';
		$this->vidout_folder='videos.out';
		
		$this->input_file=$input_file;
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
			$id=$this->id;
			$input_file=$this->input_file;
			$imgsrc_folder=$this->imgsrc_folder;
			$query="ffmpeg -i $input_file -r 25 -f image2 $id/$imgsrc_folder/image-%3d.jpeg";
			shell_exec($query);
		}
	}
	
	function encode()
	{
		if(!$this->error)
		{
			$id=$this->id;
			$vidout_folder=$this->vidout_folder;
			$imgsrc_folder=$this->imgsrc_folder;
			$output_file=$this->output_file;
			$query="ffmpeg -f image2 -r 25 -i $id/$imgsrc_folder/image-%03d.jpeg  $id/$output_file";
			echo $query;
			shell_exec($query);
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
		//sleep(3);
		$id=$this->id;	
		
		if ($handle = opendir($id.'/'.$this->imgsrc_folder)) 
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
	
	function add_filter($size,$angle,$x,$y,$t1,$t2,$t3,$t4,$t5,$t6)
	{
		$id=$this->id;
		$src_images=$this->src_images;
		foreach($src_images as $image)
		{
			$img=imagecreatefromjpeg($id.'/'.$image);
			$black = imagecolorallocate($img, 0, 0, 0);
			imagettftext($img,$size,$angle,$x,$y,$black,"fonts/testfont.ttf",$t1);
			imagettftext($img,$size,$angle,$x,$y+50,$black,"fonts/testfont.ttf",$t2);
			imagettftext($img,$size,$angle,$x,$y+100,$black,"fonts/testfont.ttf",$t3);
			imagettftext($img,$size,$angle,$x,$y+150,$black,"fonts/testfont.ttf",$t4);
			imagettftext($img,$size,$angle,$x,$y+200,$black,"fonts/testfont.ttf",$t5);
			imagettftext($img,$size,$angle,$x,$y+250,$black,"fonts/testfont.ttf",$t6);
			imagejpeg($img,$id.'/'.$image);
			imagedestroy($img);
		}
	}	
}
