<?php


namespace StanSmith\ImageManager;

class ImageManager
{
	public static function resize($src_file, $dst_file, $dst_width = null, $dst_height = null)
	{
		clearstatcache(true, $src_file);
// d($src_file);
//
		if (!file_exists($src_file) || !filesize($src_file))
			return false;

		list($src_width, $src_height, $type) = getimagesize($src_file);

		if( !$dst_width )
			$dst_width = $src_width / 2;

		if( !$dst_height )
			$dst_height = $src_height / 2;


// d($src_width);
		$file_type = 'png';
		if (!$src_width)
			return false;

		$width_diff = $src_width / $dst_width;

		$dst_height = $src_height/ $width_diff;

		$src_image = ImageManager::create($type, $src_file );

		$dest_image = imagecreatetruecolor($dst_width, $dst_height);

		imagecopyresampled($dest_image, $src_image, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
		return (ImageManager::write($file_type, $dest_image, $dst_file));
	}

	public static function create($type, $filename)
	{
		switch ($type)
		{
			case IMAGETYPE_GIF :
				return imagecreatefromgif($filename);
			break;

			case IMAGETYPE_PNG :
				return imagecreatefrompng($filename);
			break;

			case IMAGETYPE_JPEG :
			default:
				return imagecreatefromjpeg($filename);
			break;
		}
	}

	public static function write( $type, $resource, $filename )
	{
		switch( $type )
		{
			case 'gif':
				$success = imagegif($resource, $filename );
			break;

			case 'png':
				$success = imagepng( $resource, $filename, 9);
			break;

			case 'jpeg':
			case  'jpg':
			default:
				$success = imagejpeg( $resource, $filename, 90);
			break;
		}
		imagedestroy( $resource );
		@chmod($filename, 0664);
		return $success;
	}


}
