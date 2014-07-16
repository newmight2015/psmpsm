<?php
list($path) = explode(DIRECTORY_SEPARATOR.'wp-content', dirname(__FILE__).DIRECTORY_SEPARATOR);
include $path.DIRECTORY_SEPARATOR.'wp-load.php';

header("Content-Type: text/html; charset=UTF-8");
if(!stristr($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) wp_die('KBoard : '.__('This page is restricted from external access.', 'kboard'));

$uid = intval($_GET['uid']);
$file = addslashes(kboard_xssfilter(kboard_htmlclear(trim($_GET['file']))));

if(!$uid || !$file){
	die('<script>alert("'.__('You do not have permission.', 'kboard').'");history.go(-1);</script>');
}

$content = new KBContent();
$content->initWithUID($uid);
$board = new KBoard($content->board_id);

if(!$board->isReader($content->member_uid, $content->secret)){
	if(!$user_ID) die('<script>alert("'.__('Please Log in to continue.', 'kboard').'");location.href="'.wp_login_url().'";</script>');
	else die('<script>alert("'.__('You do not have permission.', 'kboard').'");history.go(-1);</script>');
}

$file_info = $wpdb->get_row("SELECT * FROM `{$wpdb->prefix}kboard_board_attached` WHERE `content_uid`='$uid' AND `file_key`='$file'");

list($path) = explode(DIRECTORY_SEPARATOR.'wp-content', dirname(__FILE__).DIRECTORY_SEPARATOR);
$path = $path.str_replace('/', DIRECTORY_SEPARATOR, $file_info->file_path);
$name = $file_info->file_name;

if(!$file_info->file_path || !file_exists($path)){
	die('<script>alert("'.__('You do not have permission.', 'kboard').'");history.go(-1);</script>');
}

header('Content-type: '.kboard_mime_type($path));
header('Content-Disposition: attachment; filename="'.iconv('UTF-8','EUC-KR//IGNORE',str_replace(' ','-',$name)).'"');
header('Content-Transfer-Encoding: binary');
header('Content-length: '.filesize($path));
header('Cache-control: private');
header('Pragma: private');
header('Expires: 0');

$fp = fopen($path, "rb");
if(!fpassthru($fp)) fclose($fp);
?>