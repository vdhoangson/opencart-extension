<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelExtensionPenBlogImage extends Model {
	private $image;
	private $info;
	/* Cropsize */
	// Function to crop an image with given dimensions. What doesn/t fit will be cut off.
	public function cropsize($filename, $width, $height) {
		$http_img = $this->store_url.'image/';
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} else {
			$fileimg = DIR_IMAGE . $filename;
		}

		$info = pathinfo($filename);
		$extension = $info['extension'];

		$old_image = $filename;
		$new_image = $this->image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-cr-' . $width . 'x' . $height . '.' . $extension;

		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}
			$oldinfo = getimagesize(DIR_IMAGE . $filename);


			//$image = new Image(DIR_IMAGE . $old_image);
			$this->mcropsize($fileimg, $width, $height);
			$this->imgsave(DIR_IMAGE . $new_image);

		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return $http_img . $new_image;
		} else {
			return $http_img . $new_image;
		}

	}



	public function imgsave($file, $quality = 90) {
		$info = pathinfo($file);

		$extension = strtolower($info['extension']);

		if (is_resource($this->image)) {
			if ($extension == 'jpeg' || $extension == 'jpg') {
				imagejpeg($this->image, $file, $quality);
			} elseif ($extension == 'png') {
				imagepng($this->image, $file);
			} elseif ($extension == 'gif') {
				imagegif($this->image, $file);
			}

			imagedestroy($this->image);
		}
	}

	public function mcropsize($file, $width, $height) {
	    $this->getInfoImage($file);
    	if (!$this->info['width'] || !$this->info['height']) {
    		return;
    	}
        //afmetingen bepalen
        $photo_width = $this->info['width'];
        $photo_height = $this->info['height'];

        $new_width = $width;
        $new_height = $height;

        //als foto te hoog is
        if (($photo_width/$new_width) < ($photo_height/$new_height)) {

        	$from_y = ceil(($photo_height - ($new_height * $photo_width / $new_width))/2);
        	$from_x = '0';
        	$photo_y = ceil(($new_height * $photo_width / $new_width));
        	$photo_x = $photo_width;

        }

        //als foto te breed is
        if (($photo_height/$new_height) < ($photo_width/$new_width)) {

        	$from_x = ceil(($photo_width - ($new_width * $photo_height / $new_height))/2);
        	$from_y = '0';
        	$photo_x = ceil(($new_width * $photo_height / $new_height));
        	$photo_y = $photo_height;

    	}

        //als verhoudingen gelijk zijn
        if (($photo_width/$new_width) == ($photo_height/$new_height)) {

        	$from_x = ceil(($photo_width - ($new_width * $photo_height / $new_height))/2);
        	$from_y = '0';
        	$photo_x = ceil(($new_width * $photo_height / $new_height));
        	$photo_y = $photo_height;

        }

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


        imagecopyresampled($this->image, $image_old, 0, 0, $from_x, $from_y, $new_width, $new_height, $photo_x, $photo_y);
        imagedestroy($image_old);

        $this->info['width']  = $width;
        $this->info['height'] = $height;


    }

    private function getInfoImage($file){
    	if (file_exists($file)) {
			$info = getimagesize($file);

			$this->info = array(
				'width'  => $info[0],
				'height' => $info[1],
				'bits'   => $info['bits'],
				'mime'   => $info['mime']
			);

			$this->image = $this->create($file);
		} else {
			exit('Error: Could not load image ' . $file . '!');
		}
    }

    private function create($image) {
		$mime = $this->info['mime'];

		if ($mime == 'image/gif') {
			return imagecreatefromgif($image);
		} elseif ($mime == 'image/png') {
			return imagecreatefrompng($image);
		} elseif ($mime == 'image/jpeg') {
			return imagecreatefromjpeg($image);
		}
	}
}
?>