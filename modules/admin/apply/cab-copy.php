<?php
if(isset($_GET['edit'])){
    $param = ApplyCard::param(4, array('mailing_copy'));

    if(isset($_POST['ok'], $_POST['text_copy'], $_POST['mailing_copy'])){
        $error = array();
        $file = array();
        $_POST = trimAll($_POST);

        $check['text_copy'] = (empty($_POST['text_copy'])? 'error' : '');
        $check['mailing_copy'] = (empty($_POST['mailing_copy']) || !isset($param['mailing_copy'][$_POST['mailing_copy']])? 'class="error"' : '');

        if(in_array('class="error"', $check) || in_array('error', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            q("
                UPDATE `admin_cab_copy_info` SET
                `text_copy`    = '".$_POST['text_copy']."',
                `mailing_copy` = '".$_POST['mailing_copy']."'
                WHERE `id`   = '".mres($_GET['edit'])."'
            ");

            sessionInfo('/admin/apply/cab-copy/', $messG['Редагування пройшло успішно!'], 1);
        }
    }

    $arResult = q("
        SELECT *
        FROM `admin_cab_copy_info`
        WHERE `id` = ".(int)$_GET['edit']."
        LIMIT 1
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/apply/cab-copy/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        if(!isset($_POST) || count($_POST) <= 0){
            $_POST = hsc($arResult->fetch_assoc());
        }
    }
} else {
    if(isset($_GET['ajax'], $_GET['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_cab_copy_info', '/admin/apply/cab-copy/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_cab_copy_info', '/admin/apply/cab-copy/', $messG['Редагування пройшло успішно!']);
    } elseif(isset($_GET['delete']) || isset($_POST['delete'])) { // Delete
        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_GET['delete']);
        if($ids != $messG['Видалити']){
            AdminFunction::deleteEl($ids, 'admin_cab_copy_info', '/admin/apply/cab-copy/', $messG['Видалення пройшло успішно!']);
        }
    }

    // Filter
    if(isset($_GET['filterReset'])){
        header('Location: /admin/apply/cab-copy/');
    }

    $cabCopyAgency = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_cab_copy_info",
        'url'        => "/admin/apply/cab-copy/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}