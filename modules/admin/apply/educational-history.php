<?php
if(isset($_GET['edit'])){
    $param = array_merge(ApplyCard::param(2), ApplyCard::param('glob', array(
        'country_study',
        'date_yyyy_from',
        'date_yyyy_to',
        'date_mm_from',
        'date_mm_to'
    )));

    if(isset($_POST['ok'])){
        $error = array();
        $file = array();
        $_POST = trimAll($_POST);

        $check['country_study'] = (empty($_POST['country_study']) || !isset($param['country_study'][$_POST['country_study']])? 'class="error"' : '');
        $check['city'] = (empty($_POST['city'])? 'class="error"' : '');
        $check['name_institution'] = (empty($_POST['name_institution'])? 'class="error"' : '');
        $check['date_mm_from'] = (empty($_POST['date_mm_from']) || !isset($param['date_mm_from'][$_POST['date_mm_from']])? 'class="error"' : '');
        $check['date_yyyy_from'] = (empty($_POST['date_yyyy_from']) || !isset($param['date_yyyy_from'][$_POST['date_yyyy_from']])? 'class="error"' : '');
        $check['date_mm_to'] = (empty($_POST['date_mm_to']) || !isset($param['date_mm_to'][$_POST['date_mm_to']])? 'class="error"' : '');
        $check['date_yyyy_to'] = (empty($_POST['date_yyyy_to']) || !isset($param['date_yyyy_to'][$_POST['date_yyyy_to']])? 'class="error"' : '');
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
                WHERE `id`   = '".mres($_GET['edit'])."'
            ");

            sessionInfo('/admin/apply/educational-history/', $messG['Редагування пройшло успішно!'], 1);
            exit();
        }
    }

    $arResult = q("
        SELECT *
        FROM `admin_educational_history`
        WHERE `id` = ".(int)$_GET['edit']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/apply/educational-history/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        if(!isset($_POST) || count($_POST) <= 0){
            $_POST = hsc($arResult->fetch_assoc());
            $_POST['fileScan'] = explode('#|#', $_POST['fileScan']);
        }
    }
} else {
    if(isset($_GET['ajax'], $_GET['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_educational_history', '/admin/apply/educational-history/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_educational_history', '/admin/apply/educational-history/', $messG['Редагування пройшло успішно!']);
    } elseif(isset($_GET['delete']) || isset($_POST['delete'])) { // Delete
        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_GET['delete']);
        if($ids != $messG['Видалити']){
            AdminFunction::deleteEl($ids, 'admin_educational_history', '/admin/apply/educational-history/', $messG['Видалення пройшло успішно!']);
        }
    }

    // Filter
    if(isset($_GET['filterReset'])){
        header('Location: /admin/apply/educational-history/');
    }

    $history = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_educational_history",
        'url'        => "/admin/apply/educational-history/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}