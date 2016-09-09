<?php
if(isset($_POST['ok'])){
    $error = array();
    $_POST = trimAll($_POST);

    if(!count($error)){
        $_POST = mres($_POST);
        $_POST['active_block_site'] = !isset($_POST['active_block_site'])? 0 : (int)$_POST['active_block_site'];


        $arImage = array(
            'brandPhoto'  => $_POST['brandPhoto'],
            'logo_system' => $_POST['logo_system']
        );

        foreach($arImage as $k => $v){
            if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                rename($_SERVER['DOCUMENT_ROOT'].$v, $_SERVER['DOCUMENT_ROOT'].'/uploaded/admin/'.basename($v));
                $_POST[$k] = '/uploaded/admin/'.basename($v);
            }
        }

        q(" UPDATE `admin_personal_interface` SET
            `logo_system`       = '".$_POST['logo_system']."',
            `version_php`       = '".$_POST['version_php']."',
            `web_server`        = '".$_POST['web_server']."',
            `version_core`      = '".$_POST['version_core']."',
            `address_site`      = '".$_POST['address_site']."',
            `site_create`       = '".$_POST['site_create']."',
            `responsible_face`  = '".$_POST['responsible_face']."',
            `support_seo`       = '".(int)$_POST['support_seo']."',
            `support_site`      = '".(int)$_POST['support_site']."',
            `monthly_fee`       = '".$_POST['monthly_fee']."',
            `phone`             = '".$_POST['phone']."',
            `email`             = '".$_POST['email']."',
            `active_block_site` = '".$_POST['active_block_site']."',
            `brand_site`        = '".$_POST['brand_site']."',
            `brandPhoto`        = '".$_POST['brandPhoto']."'
            WHERE `id` = 1
        ");

        sessionInfo('/admin/setting/personal-interface/', $messG['Редагування пройшло успішно!'], 1);
    }
}

// Ajax
if(isset($_REQUEST['getType']) && isset($_REQUEST['ajax']) && isset($_POST['data-priority-type'])){
    echo(isset($_FILES['file'])? json_encode(UploaderFiles::getType($_FILES['file'], $_POST['data-priority-type'])) : json_encode(array('error' => 'Limit file memory!')));
    exit();
} elseif(isset($_REQUEST['ajax']) && isset($_REQUEST['addFile']) && isset($_FILES['file'])) {
    echo json_encode(UploaderFiles::file($_FILES['file']));
    exit();
} elseif(isset($_REQUEST['ajax']) && isset($_REQUEST['addImage']) && isset($_FILES['file'])) {
    echo json_encode(UploaderFiles::photo($_FILES['file']));
    exit();
} elseif(isset($_REQUEST['ajax']) && isset($_REQUEST['imgResize'])) {
    echo json_encode(UploaderFiles::resizeImage($_POST['image'], $_POST['width'], $_POST['height']));
    exit();
} elseif(isset($_REQUEST['delFile']) && !empty($_POST['file_delete'])) {
    if(file_exists($_SERVER['DOCUMENT_ROOT'].$_POST['file_delete'])){
        unlink($_SERVER['DOCUMENT_ROOT'].$_POST['file_delete']);
        echo json_encode(array('file' => 'delete'));
    } else {
        echo json_encode(array('error' => 'no files'));
    }
    exit();
}

$arResult = hsc(q("
    SELECT * 
    FROM `admin_personal_interface`
    WHERE `id` = 1
")->fetch_assoc());