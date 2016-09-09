<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: text/html; charset=utf-8');
$t = microtime(true);
session_start();

// Config
include_once './config.php';
include_once './libs/default-variables.php';

// Controller
ob_start();

// Exist file
if(!file_exists('./'.Core::$CONT.'/'.$_GET['module'].'/'.(((Core::$CONT != 'modules/admin' && $GM['detail_page'])? 'main' : $_GET['page']).'.php')) || !file_exists('./skins/'.Core::$SKIN.'/'.$_GET['module'].'/'.(((Core::$CONT != 'modules/admin' && $GM['detail_page'])? 'main' : $_GET['page']).'.tpl')) || !file_exists('./'.Core::$CONT.'/'.$_GET['module'].'/lang/lang_'.$lang.'.php') || $_GET['module'] == 'error'){

    header("HTTP/1.0 404 Not Found");
    echo bufferStartError404($lang, $link_lang);
    exit();
}

// --- LANGS FILES ---
include './'.Core::$CONT.'/lang/lang_'.$lang.'.php';
include './'.Core::$CONT.'/'.$_GET['module'].'/lang/lang_'.$lang.'.php';

// --- PAGE_MODEL ---
include './modules/allpages.php';
include './'.Core::$CONT.'/'.$_GET['module'].'/'.((Core::$CONT != 'modules/admin' && $GM['detail_page'])? 'main' : $_GET['page']).'.php';
include './modules/end_allpages.php';

// --- PAGE_VIEW ---
include './skins/'.Core::$SKIN.'/'.$_GET['module'].'/'.((Core::$CONT != 'modules/admin' && $GM['detail_page'])? 'main' : $_GET['page']).'.tpl';

$content = ob_get_contents();
ob_end_clean();

// --- VIEW CONTENT ---
if(isset($_GET['ajax'])){
    echo $content;
    exit();
}

include './skins/'.Core::$SKIN.'/'.'index.tpl';
exit();