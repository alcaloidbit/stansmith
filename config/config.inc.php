<?php

@ini_set('display_errors', 'on');

include dirname(__FILE__).'/settings.inc.php';
include dirname(__FILE__).'/../vendor/autoload.php';

define('_ROOT_', realpath( dirname(__FILE__).'/..'));

define('_MODELS_', _ROOT_.'/src/Core/');
define('_CONTROLLERS_', _ROOT_.'/src/Controller/');
define('_VIEWS_', _ROOT_.'/views/');
define('_ADMIN_VIEWS_', _VIEWS_.'/admin/');

define('_AUDIO_', _ROOT_.'/music');
define('_AUDIO_TMP_', _ROOT_.'/files');
define('_AUDIO_PUBLIC_', _ROOT_.'/public');
define('_IMAGE_', _ROOT_.'/images');


define('_MEDIA_BASE_URI_', 'http://176.31.245.123/stansmith/' );
define('_BASE_URI_', 'http://local.stansmith.io/' );


if (!function_exists('getimagesizefromstring')) {
    function getimagesizefromstring($data)
    {
        $uri = 'data://application/octet-stream;base64,' . base64_encode($data);
        return getimagesize($uri);
    }
}


function debug($obj, $kill=true)
{
	echo '<xmp style="text-align:left">';
	print_r( $obj );
	echo '</xmp><br />';
	if( $kill)
		die('END');
	return $obj;
}

function d( $obj, $k = true )
{
	return debug($obj, $k) ;
}

function p( $obj )
{
	return d($obj, false);
}


if (!defined('_MAGIC_QUOTES_GPC_'))
	define('_MAGIC_QUOTES_GPC_',         get_magic_quotes_gpc());


use \StanSmith\Core\Db;
/**
 * Sanitize data which will be injected into SQL query
 *
 * @param string $string SQL data which will be injected into SQL query
 * @param boolean $htmlOK Does data contain HTML code ? (optional)
 * @return string Sanitized data
 */
function pSQL($string, $htmlOK = false)
{
	// Avoid thousands of "Db::getInstance()"...
	static $db = false;
	if (!$db)
	    $db = Db::getInstance();

	return $db->escape($string, $htmlOK);
}



function bqSQL($string)
{
	return str_replace('`', '\`', pSQL($string));
}


?>
