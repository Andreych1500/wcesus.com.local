<?php
function __autoload($class){
    if(file_exists('./libs/class_'.$class.'.php')){
        include './libs/class_'.$class.'.php';
    }
}

function q($query, $mylti = 0, $key = 0){
    if($mylti){
        $res = DB::_($key)->multi_query($query);
    } else {
        $res = DB::_($key)->query($query);
    }

    if($res === false){
        $info = debug_backtrace();
        $error = "QUERY:".$query."<br>\n".DB::_($key)->error."<br>\n"."file: ".$info[0]['file']."<br>\n"."line: ".$info[0]['line']."<br>\n"."date: ".date("Y-m-d H:i:s")."<br>\n"."===================================";

        file_put_contents('./logs/mysql.log', strip_tags($error)."\n\n", FILE_APPEND);
        echo $error;
        exit();
    }

    return $res;
}

function bufferStartError404($lang, $link_lang){

    if(Core::$CONT != 'modules/admin'){
        ob_start();
        include './'.Core::$CONT.'/lang/lang_'.$lang.'.php';
        include './'.Core::$CONT.'/error/main.php';
        include './skins/'.Core::$SKIN.'/error/main.tpl';

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    } else {
        header("Location: /admin/");
        exit();
    }
}

function data($data){
    if($data == date('Y')){
        return $data;
    } else {
        return $data.'-'.date('Y');
    }
}

function wtf($array, $stop = false){
    echo '<pre>'.print_r($array, 1).'</pre>';
    if(!$stop){
        exit();
    }
}

function trimAll($el){
    if(!is_array($el)){
        $el = trim($el);
    } else {
        $el = array_map('trimAll', $el);
    }

    return $el;
}

function fileExist($file){
    if(!file_exists($_SERVER['DOCUMENT_ROOT'].$file)){
        return '';
    }

    return $file;
}

function hsc($el){
    if(!is_array($el)){
        $el = htmlspecialchars($el);
    } else {
        $el = array_map('hsc', $el);
    }

    return $el;
}

function mres($el, $key = 0){
    if(!is_array($el)){
        $el = DB::_($key)->real_escape_string($el);
    } else {
        $el = array_map('mres', $el);
    }

    return $el;
}

function ints($el){
    if(!is_array($el)){
        $el = (int)$el;
    } else {
        $el = array_map('ints', $el);
    }

    return $el;
}

function floatAll($el){
    if(!is_array($el)){
        $el = (float)($el);
    } else {
        $el = array_map('floatAll', $el);
    }

    return $el;
}

function myHash($var){
    $salt = 'gyrtr5ytbff';
    $salt2 = 'kdjh785tn6f';
    $var = crypt(md5($var.$salt), $salt2);

    return $var;
}

function removeDirectory($dir){
    if($objs = glob($dir."/*")){
        foreach($objs as $obj){
            is_dir($obj)? removeDirectory($obj) : unlink($obj);
        }
    }
    rmdir($dir);
}

function arrOneEmpty($ar){
    if(!is_array($ar)){
        if(empty($ar)){
            return true;
        }
    } else {
        foreach($ar as $v){
            if(empty($v)){
                return true;
            }
        }
    }

    return false;
}

function emptyArray($ar){
    foreach($ar as $v){
        if(!empty($v)){
            return false;
        }
    }

    return true;
}

function calltoPhone($el){
    if(preg_match('#^(\d{3})(\d{3})(\d{4})$#uis', $el, $matches)){
        $result = '+1-'.$matches[1].'-'.$matches[2].'-'.$matches[3];
    } else {
        $result = 'Error Format';
    }

    return $result;
}

function generationPass(){
    $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
    $max = 10;  // Кількість симповіль у паролі
    $size = strlen($chars) - 1; // Кількість символів в $char

    $password = '';

    while($max--){
        $password .= $chars[rand(0, $size)];
    }

    return $password;
}

function arrayNotKey($val, $array){
    foreach($val as $v){
        if(!array_key_exists($v, $array)){
            return true;
        }
    }

    return false;
}

function isMobile(){
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent, $matches) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4), $matches2)){
        return true;
    } else {
        return false;
    }
}

function FBytes($bytes, $precision = 2){
    $units = array(
        'B',
        'KB',
        'MB',
        'GB',
        'TB'
    );
    $bytes = max($bytes, 0);
    $pow = floor(($bytes? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);

    return round($bytes, $precision).' '.$units[$pow];
}

function file_force_download($file){
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if(ob_get_level()){
        ob_end_clean();
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: '.filesize($file));

    readfile($file);
    exit();
}

function menuExit(){
    q("
        UPDATE `admin_users_list` SET
		    `lastonline` = NOW()
		    WHERE `id` = ".(int)$_SESSION['user']['id']."
	  ");

    session_unset();
    session_destroy();
    setcookie("id", "", time() - 32556926, "/");
    setcookie("authhash", "", time() - 32556926, "/");

    header("Location: /admin/");
    exit();
}

function sessionInfo($url = '/admin/', $text = '', $set = 0, $stop = 1){

    if($set == 1){
        $icon = 'good';
        $type = 'good';
    }

    if(!$set){
        $icon = 'cross';
        $type = 'error';
    }

    $_SESSION['info'] = array(
        'text' => $text,
        'icon' => $icon,
        'type' => $type
    );

    if($stop){
        header("Location: ".$url);
        exit();
    }
}

// Variables

// Main setting module
$arMainParam = hsc(q("
    SELECT *
    FROM `admin_main_module`
    WHERE `id` = 1
")->fetch_assoc());

// Data
Core::$DATA = $arMainParam['site_data_create'];

// Error_reporting off or on
if($arMainParam['error_reporting'] == 0){
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(-1);
    ini_set('display_errors', 1);
}

// Update cache files
$vF = q('SELECT `new_resource` FROM `admin_site_cache` WHERE `id` = 1')->fetch_assoc()['new_resource'];

// Rewrite
if(isset($_GET['route'])){
    $temp = explode('/', $_GET['route']);

    if(in_array($temp[0], Core::$SITE_LANG) && $temp[0] == Core::$SITE_LANG[0]){
        $lang = $temp[0];
        $link_lang = '/'.$temp[0].'/';
    } elseif($temp[0] == 'admin') {
        Core::$CONT = Core::$CONT.'/admin';
        Core::$SKIN = 'admin';
        $link_lang = ''; // Reload page

        // Lang admin
        if(isset($_REQUEST['lang_admin']) && in_array($_REQUEST['lang_admin'], Core::$ADMIN_LANG)){
            setcookie('lang_admin', $_REQUEST['lang_admin'], time() + 36000000, '/');
            sessionInfo('/'.$_REQUEST['route'], 'Lang in admin: '.$_REQUEST['lang_admin'], 1);
        } else {
            if(isset($_REQUEST['lang_admin'])){
                sessionInfo('/'.$_REQUEST['route'], '');
            }

            if(isset($_COOKIE['lang_admin']) && in_array($_COOKIE['lang_admin'], Core::$ADMIN_LANG)){
                $lang = $_COOKIE['lang_admin'];
            } else {
                setcookie('lang_admin', Core::$ADMIN_LANG[0], time() + 36000000, '/');
                $lang = Core::$ADMIN_LANG[0];
            }
        }

        unset($temp[0]);
    } else {
        $lang = Core::$SITE_LANG[0];
        $link_lang = '/';
    }

    $i = 0;
    foreach($temp as $k => $v){
        if($i == 0){
            if(!empty($v)){
                $_GET['module'] = $v;
                Core::$SITE_DIR .= $v.'/';
            }
        } elseif($i == 1) {
            if(!empty($v)){
                $_GET['page'] = $v;
                Core::$SITE_DIR .= $v.'/';
            }
        } else {
            if(!empty($v)){
                $_GET['key'.($k - 1)] = $v;
                Core::$SITE_DIR .= $v.'/';
            }
        }
        ++$i;
    }
    unset($_GET['route']);
} else {
    $lang = Core::$SITE_LANG[0];
    $link_lang = '/';
}

// Technik site off or on
if(!$arMainParam['access_publick_page'] && Core::$CONT != 'modules/admin'){
    if(!isset($_SESSION['user']) || $_SESSION['user']['id'] != 1){
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Status: 503 Service Temporarily Unavailable');
        header('Retry-After: 480');
        header('X-Powered-By:');
        include './modules/admin/setting/technik.php';
        include './skins/admin/setting/technik.tpl';
        exit();
    }
}

// Module rewrite
if(!isset($_GET['page'])){
    $_GET['page'] = 'main';
}

// No symbol with url
if(!preg_match('#^[a-z-_0-9]*$#iu', $_GET['page'])){
    header("HTTP/1.0 404 Not Found");
    echo bufferStartError404($lang, $link_lang);
    exit();
}

if(!isset($_GET['module'])){
    $_GET['module'] = 'static';
}

$res = q("
    SELECT *
    FROM `admin_module_pages`
    WHERE `module` = '".mres($_GET['module'])."'
    AND `active` = 1
    LIMIT 1
");

if(!$res->num_rows){
    $res->close();
    header("HTTP/1.0 404 Not Found");
    echo bufferStartError404($lang, $link_lang);
    exit();
} else {
    $GM = hsc($res->fetch_assoc());
    $res->close();
}