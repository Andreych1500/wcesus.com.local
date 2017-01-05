<?php
if(Core::$CONT != 'modules/admin'){
    $style = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/skins/default/css/style.min.css');

    // Seo meta tags
    foreach(explode(',', $GM['list_length']) as $k => $v){
        if($lang == 'en'){
            Core::$META['title'] = hsc(explode('#|#', $GM['meta_title'])[$k]);
            Core::$META['keywords'] = hsc(explode('#|#', $GM['meta_keywords'])[$k]);
            Core::$META['description'] = hsc(explode('#|#', $GM['meta_description'])[$k]);
        }
    }

    // Dns loading asynchronous
    Core::$META['dns-prefetch'] = array(
        0 => $arMainParam['url_http_site'].'/',
        1 => 'https://www.google-analytics.com'
    );

    // Canonical
    Core::$META['canonical'] = $arMainParam['url_http_site'].$link_lang.(($GM['module'] == 'static')? '' : $GM['module'].'/').(isset($_GET['page'])? ($_GET['page'] == 'main'? '' : $_GET['page'].'/') : '');

    // RDFa open graph
    if($GM['open_graph_page']){
        $contentOG = '';

        $contentOG .= '<meta property="og:title" content="'.Core::$META['title'].'">
                <meta property="og:description"  content="'.Core::$META['description'].'">';

        if(!empty($GM['og_type'])){
            $contentOG .= '<meta property="og:type" content="'.hsc($GM['og_type']).'">';
        }
        if(!empty($GM['og_url'])){
            $contentOG .= '<meta property="og:url" content="'.$arMainParam['url_http_site'].(($lang == Core::$SITE_LANG[0])? '' : '/'.$lang).$GM['og_url'].'">';
        }
        if(!empty($GM['og_image'])){
            $contentOG .= '<meta property="og:image" content="'.$arMainParam['url_http_site'].$GM['og_image'].'">';
        }
    }

    // Access Cab
    if(isset($_SESSION['dataCard'])){
        $select = q("
            SELECT `id`, `idCard`, `email`, `first_name`, `last_name`
            FROM `admin_application_info`
            WHERE `email`   = '".mres($_SESSION['dataCard']['email'])."'
            AND `idCardHash` = '".mres(ApplyCard::hash($_SESSION['dataCard']['idCard'].$_SESSION['dataCard']['email']))."'
            AND `active` = 1
            AND `access` = 1
            LIMIT 1
        ");

        if($select->num_rows){
            $_SESSION['dataCard'] = hsc($select->fetch_assoc());
            $accessCab = true;
        } else {
            session_unset();
            session_destroy();
            setcookie("id-idCard", "", time() - 3600, "/");
            setcookie("dataCard", "", time() - 3600, "/");

            header("Location: /cab/");
            exit();
        }
    } elseif(isset($_COOKIE['dataCard'], $_COOKIE['id-idCard'])) {
        $auth = q("
            SELECT `id`, `idCard`, `email`, `first_name`, `last_name`
            FROM `admin_application_info`
            WHERE `idCardHash` = '".mres($_COOKIE['dataCard'])."'
            AND `id` = '".mres($_COOKIE['id-idCard'])."'
            AND `active` = 1
            AND `access` = 1
            AND `user_ip` = '".mres($_SERVER['REMOTE_ADDR'])."'
            AND `agent` = '".mres($_SERVER['HTTP_USER_AGENT'])."'
            LIMIT 1
        ");

        if($auth->num_rows){
            $_SESSION['dataCard'] = $auth->fetch_assoc();
            $accessCab = true;
        } else {
            session_unset();
            session_destroy();
            setcookie("id-idCard", "", time() - 3600, "/");
            setcookie("dataCard", "", time() - 3600, "/");

            header("Location: /cab/");
            exit();
        }
    } else {
        $accessCab = false;
    }

    // Exit
    if(isset($_GET['exit'])){
        session_unset();
        session_destroy();
        setcookie("id-idCard", "", time() - 3600, "/");
        setcookie("dataCard", "", time() - 3600, "/");

        header("Location: /cab/");
        exit();
    }

    $menu = array(
        'Home'        => array(
            'this'         => '/',
            'About Us'     => '/static/about-us/',
            'Credentials'  => '/static/credentials/',
            'Office Hours' => '/static/office-hours/'
        ),
        'Students'    => array(
            'this'                => '/for-students/',
            'Educational Guide'   => '/for-students/educational-guide/',
            'Educational Systems' => '/for-students/educational-systems/',
            'Required Documents'  => '/for-students/required-documents/',
            'FAQ'                 => '/for-students/faq/'
        ),
        'Job Seekers' => array(
            'this'               => '/job-seekers/',
            'Employment Guide'   => '/job-seekers/employment-guide/',
            'Working in the USA' => '/job-seekers/working-usa/',
            'Required Documents' => '/job-seekers/required-documents/',
            'FAQ'                => '/job-seekers/faq/'
        ),
        'Immigrants'  => array(
            'this'               => '/immigrants/',
            'Immigration Guide'  => '/immigrants/immigration-guide/',
            'Coming to the USA'  => '/immigrants/coming-usa/',
            'Required Documents' => '/immigrants/required-documents/',
            'FAQ'                => '/immigrants/faq/'
        ),
        'Fees'        => '/static/fees/',
        'Apply Now'   => '/apply/',
    );
} else {

    // Access
    if(isset($_SESSION['user'])){
        $arAccess = q("
            SELECT *
            FROM `admin_users_list`
            WHERE `id` = ".(int)$_SESSION['user']['id']."
            AND `active` != 0
            AND `access` = 5
            LIMIT 1
	      ");

        if($arAccess->num_rows){
            $_SESSION['user'] = $arAccess->fetch_assoc();
            $globalAccess = true;
        } else {
            menuExit();
        }
    } elseif(isset($_COOKIE['authhash'], $_COOKIE['id'])) {
        $auth = q("
            SELECT *
			      FROM `admin_users_list`
			      WHERE `hash` = '".mres($_COOKIE['authhash'])."'
            AND `id`   = ".(int)$_COOKIE['id']."
            AND `active` != 0
			      AND `access` = 5
			      AND `user_ip` = '".mres($_SERVER['REMOTE_ADDR'])."'
			      AND `agent` = '".mres($_SERVER['HTTP_USER_AGENT'])."'
			      LIMIT 1
	      ");

        if($auth->num_rows){
            $_SESSION['user'] = $auth->fetch_assoc();
            $globalAccess = true;
        } else {
            menuExit();
        }
    } else {
        $globalAccess = false;

        if($_GET['module'] != 'static'){
            header("Location: /admin/");
            exit();
        }
    }

    // Exit
    if(isset($_GET['exit'])){
        menuExit();
    }

    // Menu
    if(isset($_COOKIE['act-menu-lv2'])){
        $arrayActMenu = (array)json_decode($_COOKIE['act-menu-lv2']);
    }

    // Admin menu
    include './modules/admin/admin_menu.php';
}