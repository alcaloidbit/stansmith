<?php

include dirname(__FILE__).'/config/config.inc.php';

$res = Db::getInstance()->select('SELECT * FROM `song` ');

foreach( $res as $s )
{
	$album = new Album( $s['id_album']);
	$str = _AUDIO_.'/'.$album->artistName.'/'.$album->dirname.'/'.$s['filename'];

	$res = Db::getInstance()->getValue('select `ID` FROM `files` WHERE  `filename` = \''.mysql_real_escape_string($str).'\'');

	if( $res )
		Db::getInstance()->exec('UPDATE `files` SET `id_song` = '.$s['id_song'].' WHERE `ID` = '.$res.'');

}
