<?php

namespace StanSmith\Core;

class Tools
{
	public static function base64_to_jpeg( $base64_string, $output_file )
	{
	    $ifp = fopen($output_file, "wb");
	    fwrite($ifp, base64_decode($base64_string));
	    fclose($ifp);

	    return $output_file; /// TODO : put the image file in image dir
	}

	public static function getExtension( $str )
	{
		return strrchr( $str, '.');
	}

	public static function excludeExtension( $path )
	{
		$extension = pathinfo( $path, PATHINFO_EXTENSION);

		$validExt = array(  1=>'m4a' ,2=>'ogg', 3=>'mp3', 4=>'wma' );
			if( !in_array( $extension , $validExt ))
				return false;
			return true;
	}

	public static function generateCallTrace()
	{
	    $e = new \Exception();
	    $trace = explode("\n", $e->getTraceAsString());
	    // reverse array to make steps line up chronologically
	    $trace = array_reverse($trace);
	    array_shift($trace); // remove {main}
	    array_pop($trace); // remove call to this method
	    $length = count($trace);
	    $result = array();

	    for ($i = 0; $i < $length; $i++)
	    {
	        $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
	    }

	    return "\t" . implode("\n\t", $result);
	}

	/**
	 * Display error and dies or silently log the error.
	 *
	 * @param string $msg
	 * @param bool $die
	 * @return bool success of logging
	 */
	public static function dieOrLog($msg, $die = false )
	{
		if ($die)
			die($msg);
		return Logger::addLog($msg);
	}


	public static function getValue( $key, $default_value = false )
	{
		if( !isset( $key ) || empty( $key ) || !is_string( $key ))
			return  false;
		$ret = ( isset($_POST[$key]) ? $_POST[$key] : (isset( $_GET[$key] ) ? $_GET[$key] : $default_value ) );

		if( is_string( $ret ) === true )
			$ret = urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret)));
		return !is_string($ret) ? $ret : stripslashes($ret);
	}

	/**
	* Delete directory and subdirectories
	*
	* @param string $dirname Directory name
	*/
	public static function deleteDirectory($dirname, $delete_self = true)
	{
		$dirname = rtrim($dirname, '/').'/';
		// @chmod($dirname, 0777);
		if ($files = scandir($dirname))
		{
			foreach ($files as $file)
			if ($file != '.' && $file != '..' && $file != '.svn')
			{
				if (is_dir($dirname.$file))
					Tools::deleteDirectory($dirname.$file, true);
				elseif (file_exists($dirname.$file))
					unlink($dirname.$file);
			}
			if ($delete_self)
				rmdir($dirname);
		}
	}


	/**
	* Random password generator
	*
	* @param integer $length Desired length (optional)
	* @param string $flag Output type (NUMERIC, ALPHANUMERIC, NO_NUMERIC)
	* @return string Password
	*/
	public static function randGen($length = 8, $flag = 'ALPHANUMERIC')
	{
		switch ($flag)
		{
			case 'NUMERIC':
				$str = '0123456789';
				break;
			case 'NO_NUMERIC':
				$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			default:
				$str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
		}

		for ($i = 0, $passwd = ''; $i < $length; $i++)
			$passwd .= Tools::substr($str, mt_rand(0, Tools::strlen($str) - 1), 1);
		return $passwd;
	}

	public static function substr($str, $start, $length = false, $encoding = 'utf-8')
	{
		if (is_array($str))
			return false;
		if (function_exists('mb_substr'))
			return mb_substr($str, (int)$start, ($length === false ? Tools::strlen($str) : (int)$length), $encoding);
		return substr($str, $start, ($length === false ? Tools::strlen($str) : (int)$length));
	}


	public static function strlen($str, $encoding = 'UTF-8')
	{
		if (is_array($str))
			return false;
		$str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
		if (function_exists('mb_strlen'))
			return mb_strlen($str, $encoding);
		return strlen($str);
	}


	/**  ( From Prestashop Source )
	 * Return a friendly url made from the provided string
	 * If the mbstring library is available, the output is the same as the js function of the same name
	 *
	 * @param string $str
	 * @return string
	 */
	public static function str2url($str)
	{
		$allow_accented_chars = false;

		$str = trim($str);

		if (function_exists('mb_strtolower'))
			$str = mb_strtolower($str, 'utf-8');
		elseif (!$allow_accented_chars)
			$str = Tools::replaceAccentedChars($str);

		// Remove all non-whitelist chars.
		if ($allow_accented_chars)
			$str = preg_replace('/[^a-zA-Z0-9\s\'\:\/\[\]-\pL]/u', '', $str);
		else
			$str = preg_replace('/[^a-zA-Z0-9\s\'\:\/\[\]-]/','', $str);

		$str = preg_replace('/[\s\'\:\/\[\]-]+/', ' ', $str);
		$str = str_replace(array(' ', '/'), '-', $str);

		// If it was not possible to lowercase the string with mb_strtolower, we do it after the transformations.
		// This way we lose fewer special chars.
		if (!function_exists('mb_strtolower'))
			$str = strtolower($str);

		return $str;
	}

	/**  ( Copy From Prestashop Source Code )
	 * Replace all accented chars by their equivalent non accented chars.
	 *
	 * @param string $str
	 * @return string
	 */
	public static function replaceAccentedChars($str)
	{
		$patterns = array(
			/* Lowercase */
			'/[\x{0105}\x{00E0}\x{00E1}\x{00E2}\x{00E3}\x{00E4}\x{00E5}]/u',
			'/[\x{00E7}\x{010D}\x{0107}]/u',
			'/[\x{010F}]/u',
			'/[\x{00E8}\x{00E9}\x{00EA}\x{00EB}\x{011B}\x{0119}]/u',
			'/[\x{00EC}\x{00ED}\x{00EE}\x{00EF}]/u',
			'/[\x{0142}\x{013E}\x{013A}]/u',
			'/[\x{00F1}\x{0148}]/u',
			'/[\x{00F2}\x{00F3}\x{00F4}\x{00F5}\x{00F6}\x{00F8}]/u',
			'/[\x{0159}\x{0155}]/u',
			'/[\x{015B}\x{0161}]/u',
			'/[\x{00DF}]/u',
			'/[\x{0165}]/u',
			'/[\x{00F9}\x{00FA}\x{00FB}\x{00FC}\x{016F}]/u',
			'/[\x{00FD}\x{00FF}]/u',
			'/[\x{017C}\x{017A}\x{017E}]/u',
			'/[\x{00E6}]/u',
			'/[\x{0153}]/u',

			/* Uppercase */
			'/[\x{0104}\x{00C0}\x{00C1}\x{00C2}\x{00C3}\x{00C4}\x{00C5}]/u',
			'/[\x{00C7}\x{010C}\x{0106}]/u',
			'/[\x{010E}]/u',
			'/[\x{00C8}\x{00C9}\x{00CA}\x{00CB}\x{011A}\x{0118}]/u',
			'/[\x{0141}\x{013D}\x{0139}]/u',
			'/[\x{00D1}\x{0147}]/u',
			'/[\x{00D3}]/u',
			'/[\x{0158}\x{0154}]/u',
			'/[\x{015A}\x{0160}]/u',
			'/[\x{0164}]/u',
			'/[\x{00D9}\x{00DA}\x{00DB}\x{00DC}\x{016E}]/u',
			'/[\x{017B}\x{0179}\x{017D}]/u',
			'/[\x{00C6}]/u',
			'/[\x{0152}]/u');

		$replacements = array(
				'a', 'c', 'd', 'e', 'i', 'l', 'n', 'o', 'r', 's', 'ss', 't', 'u', 'y', 'z', 'ae', 'oe',
				'A', 'C', 'D', 'E', 'L', 'N', 'O', 'R', 'S', 'T', 'U', 'Z', 'AE', 'OE'
			);

		return preg_replace($patterns, $replacements, $str);
	}

	public static function isEmpty($field)
	{
		return ($field === '' || $field === null);
	}

	public static function instantSearch( $entity, $key, $value )
	{
		$req  = 'SELECT `'.$key.'` as `value`, `'.$key.'` as `label`  FROM `'.$entity.'` WHERE `dirname` LIKE \'%'.$value.'%\'';
		return Db::getInstance()->select( $req );
	}

	public static function makedir( $parent, $dirname )
	{
		$structure = $parent.'/'.str_replace('/', '_', $dirname);
		 if( !mkdir( $structure, 0777, dio_truncate(fd, offset)))
		 		return false;
		 else
		 		return $parent.'/'.$dirname;
	}

	public static function truncate($string, $max_length, $replacement = '', $trunc_at_space = false )
	{
		$max_length -= strlen($replacement);
		$string_length = strlen( $string);

		if($string_length <= $max_length)
			return $string;

		if( $trunc_at_space && ($space_position = strrpos($string, ' ', $max_length-$string_length)))
				$max_length = $space_position;

		return substr_replace($string, $replacement, $max_length);
	}


	public static function formatTrackNumber($data)
	{
		if(!is_array($data))
			return;
		$pattern = '#track_?number#i';
		if($k = self::preg_array_key_exists($pattern, $data)){
			if( strpos($k, '/'))
				return substr($k, 0, strpos($k, '/'));
			return $k;
		}else{
			return '';
		}
	}

	public static function formatCreationDate($str)
	{
		return substr($str, 0, 4);
	}

	public static function formatTrackYear($data)
	{
		if(!is_array($data))
			return;
		if(array_key_exists('year', $data))
			return $data['year'][0];
		elseif(array_key_exists('creation_date', $data))
			return self::formatCreationDate($data['creation_date'][0]);
		elseif(array_key_exists('date', $data))
			return $data['date'][0];
		else
			return false;
	}

	public static function preg_array_key_exists($pattern, $array)
	{
		$keys = array_keys($array);
		foreach( $keys as $key){
			if( preg_match($pattern, $key) == 1){
				return $array[$key][0];
			}
		}
		return false;
	}


		/**
	 * Convert \n and \r\n and \r to <br />
	 *
	 * @param string $string String to transform
	 * @return string New string
	 */
	public static function nl2br($str)
	{
		return str_replace(array("\r\n", "\r", "\n"), '<br />', $str);
	}

}
