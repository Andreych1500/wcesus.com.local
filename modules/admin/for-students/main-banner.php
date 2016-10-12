<?php
if(isset($_GET['add'])){
    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['name'] = (empty($_POST['name'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);
            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['sort'] = (!isset($_POST['sort'])? 100 : $_POST['sort']);

            q("
                INSERT INTO `admin_main_banner` SET
                `sort`        = ".(int)$_POST['sort'].",
                `active`      = ".$_POST['active'].",
                `name`        = '".$_POST['name']."',
                `user_custom` = '".$_SESSION['user']['last_name'].' '.$_SESSION['user']['name']."',
                `date_create` = NOW()
            ");

            sessionInfo('/admin/for-students/main-banner/', $messG['Елемент створено успішно!'], 1);
        }
    }
} elseif(isset($_GET['edit'])) {

    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['name'] = (empty($_POST['name'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);
            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['sort'] = (!isset($_POST['sort'])? 100 : $_POST['sort']);

            $arFile = array(
                'img' => $_POST['img'],
            );

            foreach($arFile as $k => $v){
                if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                    rename($_SERVER['DOCUMENT_ROOT'].$v, $_SERVER['DOCUMENT_ROOT'].'/uploaded/banner/'.basename($v));
                    $_POST[$k] = '/uploaded/banner/'.basename($v);
                }
            }

            q("
                UPDATE `admin_main_banner` SET
                `active`      = ".$_POST['active'].",
                `sort`        = ".(int)$_POST['sort'].",
                `name`        = '".$_POST['name']."',
                `img`         = '".$_POST['img']."',
                `img_seo_title` = '".$_POST['img_seo_title']."',
                `img_seo_alt` = '".$_POST['img_seo_alt']."',
                `user_custom` = '".$_SESSION['user']['last_name'].' '.$_SESSION['user']['name']."',
                `date_custom` = NOW()
                 WHERE `id` = ".(int)$_GET['edit']."
            ");

            sessionInfo('/admin/for-students/main-banner/', $messG['Редагування пройшло успішно!'], 1);
        }
    }

    $arResult = q("
        SELECT *
        FROM `admin_main_banner`
        WHERE `id` = ".(int)$_GET['edit']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/for-students/main-banner/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        $arResult = hsc($arResult->fetch_assoc());
    }
} else {
    if(isset($_GET['ajax'], $_GET['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_main_banner', '/admin/for-students/main-banner/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_main_banner', '/admin/for-students/main-banner/', array(
            $messG['Редагування пройшло успішно!'],
        ));
    } elseif(isset($_GET['delete']) || isset($_POST['delete'])) { // Delete
        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_GET['delete']);
        if($ids != $messG['Видалити']){
            AdminFunction::deleteEl($ids, 'admin_main_banner', '/admin/for-students/main-banner/', $messG['Видалення пройшло успішно!']);
        }
    } elseif(isset($_POST['deactivate']) && isset($_POST['ids'])) { // Deactivate
        AdminFunction::deactivateEl(implode(',', $_POST['ids']), 'admin_main_banner', '/admin/for-students/main-banner/', $messG['Деактивація пройшла успішно!']);
    } elseif(isset($_POST['activate']) && isset($_POST['ids'])) { // Activate
        AdminFunction::activeEl(implode(',', $_POST['ids']), 'admin_main_banner', '/admin/for-students/main-banner/', $messG['Активація пройшла успішно!']);
    }

    // Filter
    if(isset($_GET['filterReset'])){
        header('Location: /admin/for-students/main-banner/');
    }

    $main_banner = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_main_banner",
        'url'        => "/admin/for-students/main-banner/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}