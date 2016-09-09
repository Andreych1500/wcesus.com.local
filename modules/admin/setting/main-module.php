<?php
if(isset($_POST['ok'])){
    $error = array();
    $_POST = trimAll($_POST);

    $check['from_email'] = ((empty($_POST['from_email']) || !filter_var($_POST['from_email'], FILTER_VALIDATE_EMAIL))? 'class="error"' : '');
    $check['site_data_create'] = (empty($_POST['site_data_create'])? 'class="error"' : '');
    $check['url_site'] = (empty($_POST['url_site'])? 'class="error"' : '');
    $check['url_http_site'] = (empty($_POST['url_http_site'])? 'class="error"' : '');

    if(in_array('class="error"', $check)){
        $error['stop'] = 1;
    }

    if(!count($error)){
        $_POST = mres($_POST);

        q(" UPDATE `admin_main_module` SET
            `from_email`       = '".$_POST['from_email']."',
            `error_reporting`  = ".(int)$_POST['error_reporting'].",
            `site_data_create` = '".$_POST['site_data_create']."',
            `url_site`         = '".$_POST['url_site']."',
            `url_http_site`    = '".$_POST['url_http_site']."'
            WHERE `id` = 1
        ");

        sessionInfo('/admin/setting/main-module/', $messG['Редагування пройшло успішно!'], 1);
    }
}

if(isset($_REQUEST['access_publick_page'])){
    q("
        UPDATE `admin_main_module` SET
        `access_publick_page` = ".(int)$_REQUEST['access_publick_page']."
        WHERE `id` = 1
    ");
    header("Location: /admin/setting/main-module/");
    exit();
}

$arResult = q("
    SELECT *
    FROM `admin_main_module`
    WHERE `id` = 1
")->fetch_assoc();