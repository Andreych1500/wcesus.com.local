<?php
if(isset($_GET['add'])){
    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['name'] = (empty($_POST['name'])? 'class="error"' : '');
        $check['code'] = (empty($_POST['code'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        } else {
            $res = q("
			          SELECT `id`
			          FROM  `admin_country_doc`
			          WHERE `code` = '".mres($_POST['code'])."'
                LIMIT 1
            ");

            if($res->num_rows){
                $error['stop'] = 1;
                sessionInfo('/admin/for-students/?add='.$_GET['add'], 'Primary key: Code!', 0, 0);
            }
        }

        if(!count($error)){
            $_POST = mres($_POST);
            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['sort'] = (!isset($_POST['sort'])? 100 : $_POST['sort']);

            q("
                INSERT INTO `admin_country_doc` SET
                `sort`        = ".(int)$_POST['sort'].",
                `active`      = ".$_POST['active'].",
                `code`        = '".$_POST['code']."',
                `name`        = '".$_POST['name']."',
                `user_custom` = '".$_SESSION['user']['last_name'].' '.$_SESSION['user']['name']."',
                `date_create` = NOW()
            ");

            sessionInfo('/admin/for-students/', $messG['Елемент створено успішно!'], 1);
        }
    }
} elseif(isset($_GET['edit'])) {
    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['name'] = (empty($_POST['name'])? 'class="error"' : '');
        $check['code'] = (empty($_POST['code'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        } else {
            $res = q("
                SELECT `id`
                FROM  `admin_country_doc`
                WHERE `id` != ".(int)$_GET['edit']."
                AND `code` = '".mres($_POST['login'])."'
            ");

            if($res->num_rows){
                $error['stop'] = 1;
                sessionInfo('/admin/for-students/?edit='.$_GET['edit'], 'This country is exist', 0, 0);
            }
        }

        if(!count($error)){
            $_POST = mres($_POST);
            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['sort'] = (!isset($_POST['sort'])? 100 : $_POST['sort']);

            $arFile = array(
                'documents' => $_POST['documents'],
            );

            foreach($arFile as $k => $v){
                if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                    rename($_SERVER['DOCUMENT_ROOT'].$v, $_SERVER['DOCUMENT_ROOT'].'/uploaded/country/'.basename($v));
                    $_POST[$k] = '/uploaded/country/'.basename($v);
                }
            }

            q("
                UPDATE `admin_country_doc` SET
                `active`      = ".$_POST['active'].",
                `sort`        = ".(int)$_POST['sort'].",
                `name`        = '".$_POST['name']."',
                `code`        = '".$_POST['code']."',
                `documents`   = '".$_POST['documents']."',
                `user_custom` = '".$_SESSION['user']['last_name'].' '.$_SESSION['user']['name']."',
                `date_custom` = NOW()
                 WHERE `id` = ".(int)$_GET['edit']."
            ");

            sessionInfo('/admin/for-students/', $messG['Редагування пройшло успішно!'], 1);
        }
    }

    $arResult = q("
        SELECT *
        FROM `admin_country_doc`
        WHERE `id` = ".(int)$_GET['edit']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/for-students/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        $arResult = hsc($arResult->fetch_assoc());
    }
} else {
    if(isset($_GET['ajax'], $_GET['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_country_doc', '/admin/for-students/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_country_doc', '/admin/for-students/', array(
            $messG['Редагування пройшло успішно!'],
        ));
    } elseif(isset($_GET['delete']) || isset($_POST['delete'])) { // Delete
        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_GET['delete']);
        if($ids != $messG['Видалити']){
            AdminFunction::deleteEl($ids, 'admin_country_doc', '/admin/for-students/', $messG['Видалення пройшло успішно!']);
        }
    } elseif(isset($_POST['deactivate']) && isset($_POST['ids'])) { // Deactivate
        AdminFunction::deactivateEl(implode(',', $_POST['ids']), 'admin_country_doc', '/admin/for-students/', $messG['Деактивація пройшла успішно!']);
    } elseif(isset($_POST['activate']) && isset($_POST['ids'])) { // Activate
        AdminFunction::activeEl(implode(',', $_POST['ids']), 'admin_country_doc', '/admin/for-students/', $messG['Активація пройшла успішно!']);
    }

    // Filter
    if(isset($_GET['filterReset'])){
        header('Location: /admin/for-students/');
    }

    $users_list = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_country_doc",
        'url'        => "/admin/for-students/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}