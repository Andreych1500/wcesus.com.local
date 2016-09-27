<?php
if(isset($_REQUEST['edit'])){
    if(isset($_POST['ok'])){
        $error = array();
        $file = array();
        $_POST = trimAll($_POST);

        $check['country_study'] = (strlen($_POST['country_study']) == 0 || !isset(ApplyCard::param(2, 'country_study')[$_POST['country_study']])? 'class="error"' : '');
        $check['city'] = (empty($_POST['city'])? 'class="error"' : '');
        $check['name_institution'] = (empty($_POST['name_institution'])? 'class="error"' : '');
        $check['date_mm_from'] = (strlen($_POST['date_mm_from']) == 0 || !in_array($_POST['date_mm_from'], ApplyCard::param(2, 'date_mm_from'))? 'class="error"' : '');
        $check['date_yyyy_from'] = (strlen($_POST['date_yyyy_from']) == 0 || !in_array($_POST['date_yyyy_from'], ApplyCard::param(2, 'date_yyyy_from'))? 'class="error"' : '');
        $check['date_mm_to'] = (strlen($_POST['date_mm_to']) == 0 || !in_array($_POST['date_mm_to'], ApplyCard::param(2, 'date_mm_to'))? 'class="error"' : '');
        $check['date_yyyy_to'] = (strlen($_POST['date_yyyy_to']) == 0 || !in_array($_POST['date_yyyy_to'], ApplyCard::param(2, 'date_yyyy_to'))? 'class="error"' : '');
        $check['reason_text'] = (strlen($_POST['reason_text']) > 1000? 'class="error"' : '');

        if(($_POST['date_yyyy_from'] == $_POST['date_yyyy_to']) && $_POST['date_mm_from'] > $_POST['date_mm_to']){
            $check['date_mm_from'] = 'class="error"';
            $check['date_mm_to'] = 'class="error"';
        } elseif($_POST['date_yyyy_from'] > $_POST['date_yyyy_to']) {
            $check['date_yyyy_from'] = 'class="error"';
            $check['date_yyyy_to'] = 'class="error"';
        }

        $check['fileScan'] = (emptyArray($_POST['fileScan'])? 'error' : '');

        if(in_array('class="error"', $check) || in_array('error', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            foreach($_POST['fileScan'] as $k => $v){
                if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                    rename($_SERVER['DOCUMENT_ROOT'].$v, $_SERVER['DOCUMENT_ROOT'].'/uploaded/scan/'.basename($v));
                    $file['fileScan'][$k] = '/uploaded/scan/'.basename($v);
                }
            }

            $scan = trim(implode('#|#', $file['fileScan']), '#|#');

            q("
                UPDATE `admin_educational_history` SET
                `country_study`    = '".$_POST['country_study']."',
                `city`             = '".$_POST['city']."',
                `name_institution` = '".$_POST['name_institution']."',
                `date_mm_from`     = '".$_POST['date_mm_from']."',
                `date_yyyy_from`   = '".$_POST['date_yyyy_from']."',
                `date_mm_to`       = '".$_POST['date_mm_to']."',
                `date_yyyy_to`     = '".$_POST['date_yyyy_to']."',
                `fileScan`         = '".mres($scan)."',
                `diploma_name`     = '".$_POST['diploma_name']."',
                `reason_text`      = '".$_POST['reason_text']."',
                `user_custom`      = '".mres($_SESSION['user']['last_name'].' '.$_SESSION['user']['name'])."'
                WHERE `id`   = '".mres($_REQUEST['edit'])."'
            ");

            sessionInfo('/admin/cab/history/', $messG['Редагування пройшло успішно!'], 1);
            exit();
        }
    }

    $arResult = q("
        SELECT *
        FROM `admin_educational_history`
        WHERE `id` = ".(int)$_REQUEST['edit']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/cab/history/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        $param = ApplyCard::param(2);

        if(!isset($_POST) || count($_POST) <= 0){
            $_POST = hsc($arResult->fetch_assoc());
            $_POST['fileScan'] = explode('#|#', $_POST['fileScan']);
        }
    }

    Core::$JS[] = "<script src=\"/skins/admin/js/apply.min.js\" defer></script>";
} else {
    if(isset($_REQUEST['ajax'], $_REQUEST['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_educational_history', '/admin/cab/history/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_educational_history', '/admin/cab/history/', $messG['Редагування пройшло успішно!']);
    } elseif(isset($_REQUEST['delete']) || isset($_POST['delete'])) { // Delete
        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_REQUEST['delete']);
        if($ids != $messG['Видалити']){
            AdminFunction::deleteEl($ids, 'admin_educational_history', '/admin/cab/history/', $messG['Видалення пройшло успішно!']);
        }
    } elseif(isset($_POST['deactivate']) && isset($_POST['ids'])) { // Deactivate
        AdminFunction::deactivateEl(implode(',', $_POST['ids']), 'admin_educational_history', '/admin/cab/history/', $messG['Деактивація пройшла успішно!']);
    } elseif(isset($_POST['activate']) && isset($_POST['ids'])) { // Activate
        AdminFunction::activeEl(implode(',', $_POST['ids']), 'admin_educational_history', '/admin/cab/history/', $messG['Активація пройшла успішно!']);
    }

    // Filter
    if(isset($_REQUEST['filterReset'])){
        header('Location: /admin/cab/history/');
    }

    $history = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_educational_history",
        'url'        => "/admin/cab/history/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}