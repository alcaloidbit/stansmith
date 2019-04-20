<?php
error_reporting(E_ALL|E_STRICT);
include dirname(__FILE__).'/config/config.inc.php';
require('UploadHandler.php');



$path = $_POST['artist'].'/'.$_POST['album'];


$upload_dir =  dirname( __FILE__ ).'/music/'. $path.'/';
$upload_url = 'http://176.31.245.123/stansmith/music/'.$path.'/';
$options = array('upload_dir'=> $upload_dir, 'upload_url' => $upload_url );
$upload_handler = new UploadHandler( $options );






