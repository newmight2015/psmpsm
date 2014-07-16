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

if(!strstr($_SERVER['HTTP_REFERER'], basename(__file__))) $_SESSION['redirect_uri'] = $_SERVER['HTTP_REFERER'];

$content = new KBContent();
$content->initWithUID($uid);
$board = new KBoard($content->board_id);

if(!$board->isEditor($content->member_uid)){
	if($board->permission_write=='all'){
		if(!$board->isConfirm($content->password, $content->uid)){
			$url = new KBUrl();
			$skin_path = KBOARD_URL_PATH . "/skin/$board->skin";
			include KBOARD_DIR_PATH . "/skin/$board->skin/confirm.php";
			exit;
		}
	}
	elseif(!$user_ID){
		die('<script>alert("'.__('Please Log in to continue.', 'kboard').'");location.href="'.wp_login_url().'";</script>');
	}
	else{
		die('<script>alert("'.__('You do not have permission.', 'kboard').'");history.go(-1);</script>');
	}
}

if($file == 'thumbnail') $content->removeThumbnail();
else $content->removeAttached($file);

header("Location:" . $_SESSION['redirect_uri']);
?>