<?php
if(isset($_REQUEST['add'])){

    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['name'] = (empty($_POST['name'])? 'class="error"' : '');
        $check['symbol_code'] = (empty($_POST['symbol_code'])? 'class="error"' : '');

        $primary = q("
            SELECT `symbol_code`
            FROM  `admin_type_mails`
            WHERE `symbol_code` = '".mres($_POST['symbol_code'])."'
            LIMIT 1
        ");

        if($primary->num_rows > 0){
            $check['symbol_code'] = 'class="error"';
        }

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['sort'] = (!isset($_POST['sort'])? 100 : $_POST['sort']);

            q(" INSERT INTO `admin_type_mails` SET
                `active`       = ".$_POST['active'].",
                `name`         = '".$_POST['name']."',
                `sort`        = ".(int)$_POST['sort'].",
                `symbol_code`  = '".$_POST['symbol_code']."',
                `hidden_copy`  = '".$_POST['hidden_copy']."',
                `user_custom`  = '".mres($_SESSION['user']['last_name'].' '.$_SESSION['user']['name'])."',
                `date_create`  = NOW()
            ");

            sessionInfo('/admin/setting/type-mails/', $messG['Елемент створено успішно!'], 1);
        }
    }
} elseif(isset($_REQUEST['edit'])) {

    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['name'] = (empty($_POST['name'])? 'class="error"' : '');
        $check['symbol_code'] = (empty($_POST['symbol_code'])? 'class="error"' : '');
        $check['header_list'] = (empty($_POST['header_list'])? 'class="error"' : '');
        $check['why_list'] = (empty($_POST['why_list'])? 'class="error"' : '');
        $check['text'] = (empty($_POST['why_list'])? 'class="error"' : '');
        $check['theme_list'] = (empty($_POST['theme_list'])? 'class="error"' : '');

        $primary = q("
            SELECT `symbol_code`
            FROM  `admin_type_mails`
            WHERE `symbol_code` = '".mres($_POST['symbol_code'])."' AND `id` != ".(int)$_REQUEST['edit']."
            LIMIT 1
        ");

        if($primary->num_rows > 0){
            $check['symbol_code'] = 'class="error"';
        }

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['sort'] = (!isset($_POST['sort'])? 100 : $_POST['sort']);

            q(" UPDATE `admin_type_mails` SET
                `active`       = ".$_POST['active'].",
                `sort`        = ".(int)$_POST['sort'].",
                `name`         = '".$_POST['name']."',
                `symbol_code`  = '".$_POST['symbol_code']."',
                `why_list`     = '".$_POST['why_list']."',
                `header_list`  = '".$_POST['header_list']."',
                `text`         = '".$_POST['text']."',
                `theme_list`   = '".$_POST['theme_list']."',
                `hidden_copy`  = '".$_POST['hidden_copy']."',
                `user_custom`  = '".mres($_SESSION['user']['last_name'].' '.$_SESSION['user']['name'])."'
                WHERE `id` = ".(int)$_REQUEST['edit']."
            ");

            sessionInfo('/admin/setting/type-mails/', $messG['Редагування пройшло успішно!'], 1);
        }
    }

    $arResult = q("
        SELECT * 
        FROM `admin_type_mails`
        WHERE `id` = ".(int)$_REQUEST['edit']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/setting/type-mails/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        $arResult = $arResult->fetch_assoc();
    }
} elseif(isset($_REQUEST['view'])) {
    if(isset($_POST['send'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['test_email'] = ((empty($_POST['test_email']) || !filter_var($_POST['test_email'], FILTER_VALIDATE_EMAIL))? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $arResult = hsc(q("
                SELECT `symbol_code`
                FROM `admin_type_mails`
                WHERE `id` = ".(int)$_REQUEST['view']."
                LIMIT 1
            ")->fetch_assoc());

            Mail::$text = TemplateMail::HtmlMail('', $arResult['symbol_code'], $arMainParam);

            if(Mail::$text){
                Mail::$to = $_POST['test_email'];
                Mail::send();
            }

            sessionInfo('/admin/setting/type-mails/', $mess['Тестовий лист успішно відправлений!'], 1);
        }
    }

    $arResult = q("
        SELECT *
        FROM `admin_type_mails`
        WHERE `id` = ".(int)$_REQUEST['view']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/setting/type-mails/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        $template = hsc($arResult->fetch_assoc());
    }
} else {

    if(isset($_REQUEST['ajax'], $_REQUEST['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_type_mails', '/admin/setting/type-mails/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_type_mails', '/admin/setting/type-mails/', $messG['Редагування пройшло успішно!']);
    } elseif(isset($_REQUEST['delete']) || isset($_POST['delete'])) { // Delete
        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_REQUEST['delete']);
        if($ids != $messG['Видалити']){
            AdminFunction::deleteEl($ids, 'admin_type_mails', '/admin/setting/type-mails/', $messG['Видалення пройшло успішно!']);
        }
    } elseif(isset($_POST['deactivate']) && isset($_POST['ids'])) { // Deactivate
        AdminFunction::deactivateEl(implode(',', $_POST['ids']), 'admin_type_mails', '/admin/setting/type-mails/', $messG['Деактивація пройшла успішно!']);
    } elseif(isset($_POST['activate']) && isset($_POST['ids'])) { // Activate
        AdminFunction::activeEl(implode(',', $_POST['ids']), 'admin_type_mails', '/admin/setting/type-mails/', $messG['Активація пройшла успішно!']);
    }

    // Filter
    if(isset($_REQUEST['filterReset'])){
        header('Location: /admin/setting/type-mails/');
    }

    $type_mails = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_type_mails",
        'url'        => "/admin/setting/type-mails/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}