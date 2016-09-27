<?php
if(isset($_REQUEST['edit'])){
    if(isset($_POST['ok'], $_POST['text_copy'], $_POST['mailing_copy'])){
        $error = array();
        $file = array();
        $_POST = trimAll($_POST);

        $check['text_copy'] = (empty($_POST['text_copy'])? 'error' : '');
        $check['mailing_copy'] = (strlen($_POST['mailing_copy']) == 0 || !isset(ApplyCard::param(4, 'mailing_copy')[$_POST['mailing_copy']])? 'class="error"' : '');

        if(in_array('class="error"', $check) || in_array('error', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            q("
                UPDATE `admin_official_agency_copy` SET
                `text_copy`    = '".$_POST['text_copy']."',
                `mailing_copy` = '".$_POST['mailing_copy']."'
                WHERE `id`   = '".mres($_REQUEST['edit'])."'
            ");

            sessionInfo('/admin/cab/copy-agency/', $messG['Редагування пройшло успішно!'], 1);
        }
    }

    $arResult = q("
        SELECT *
        FROM `admin_official_agency_copy`
        WHERE `id` = ".(int)$_REQUEST['edit']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/cab/copy-agency/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        $param = ApplyCard::param(4);

        if(!isset($_POST) || count($_POST) <= 0){
            $_POST = hsc($arResult->fetch_assoc());
        }
    }
} else {
    if(isset($_REQUEST['ajax'], $_REQUEST['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_official_agency_copy', '/admin/cab/copy-agency/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_official_agency_copy', '/admin/cab/copy-agency/', $messG['Редагування пройшло успішно!']);
    } elseif(isset($_REQUEST['delete']) || isset($_POST['delete'])) { // Delete
        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_REQUEST['delete']);
        if($ids != $messG['Видалити']){
            AdminFunction::deleteEl($ids, 'admin_official_agency_copy', '/admin/cab/copy-agency/', $messG['Видалення пройшло успішно!']);
        }
    } elseif(isset($_POST['deactivate']) && isset($_POST['ids'])) { // Deactivate
        AdminFunction::deactivateEl(implode(',', $_POST['ids']), 'admin_official_agency_copy', '/admin/cab/copy-agency/', $messG['Деактивація пройшла успішно!']);
    } elseif(isset($_POST['activate']) && isset($_POST['ids'])) { // Activate
        AdminFunction::activeEl(implode(',', $_POST['ids']), 'admin_official_agency_copy', '/admin/cab/copy-agency/', $messG['Активація пройшла успішно!']);
    }

    // Filter
    if(isset($_REQUEST['filterReset'])){
        header('Location: /admin/cab/copy-agency/');
    }

    $copyAgency = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_official_agency_copy",
        'url'        => "/admin/cab/copy-agency/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}