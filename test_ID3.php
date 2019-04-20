<?php
include dirname(__FILE__).'/config/config.inc.php';
// include getID3() library (can be in a different directory if full path is specified)
// require_once('./getID3-master/getid3/getid3.php');

// Initialize getID3 engine
$getID3 = new getID3;

$filename = _AUDIO_PUBLIC_.'/EQZ_02-lite-brite.m4a';

// Analyze file and store returned data in $ThisFileInfo
$ThisFileInfo = $getID3->analyze($filename);


p($ThisFileInfo);
