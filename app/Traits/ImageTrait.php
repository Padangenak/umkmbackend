<?php 
namespace App\Traits;

use Image;

Trait ImageTrait{
	public function upload($file){
		$url = $file->store('images');

		return[
			"filename" => $file->hashName(),
			"path" => "/" . explode("/", $url)[0]. "/",
			"type" => $file->extension(),
			"size" => $file->getSize(),
		];
		
	}
	public function resize($img){
        // dd("asdsa");

		$image = getimagesize($img);

		$width = $image[0];
		$height = $image[1];

		$widthOver = $width*2; 
		$heightOver = $height*2;

		$widthHalf = $width/2; 
		$heightHalf = $height/2;

		$resultWidht = 0;
		$resultHeight = 0;

		if ($width == $height) {
			$resultWidht = 500;
			$resultHeight = 500;
		}else if($widthOver <= $height){
			$resultWidht = 250;
			$resultHeight = 500;
		}else if($heightOver <= $width){
			$resultWidht = 500;
			$resultHeight = 250;
		}else if($width < $height){
			$resultWidht = 350;
			$resultHeight = 500;
		}else if($width > $height){
			$resultWidht = 500;
			$resultHeight = 350;
		}
		$path = $this->upload($img);
		$result = Image::make($img->path());
		return $result->resize($resultWidht, $resultHeight, function ($constraint) {
			$constraint->aspectRatio();
		})->save(explode('/',$path['path'])[1].'\\'.$path['filename']);
	}
}