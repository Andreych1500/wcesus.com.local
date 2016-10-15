<?php
if(isset($_GET['add'])){
    if(isset($_POST['ok'], $_POST['type_faq'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['question'] = (empty($_POST['question'])? 'class="error"' : '');
        $check['type_faq'] = (!array_key_exists($_POST['type_faq'], $messG['type_faq'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);
            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['sort'] = (!isset($_POST['sort'])? 100 : $_POST['sort']);

            q("
                INSERT INTO `admin_faq` SET
                `sort`        = ".(int)$_POST['sort'].",
                `active`      = ".$_POST['active'].",
                `question`    = '".$_POST['question']."',
                `type_faq`    = ".(int)($_POST['type_faq']).",
                `user_custom` = '".$_SESSION['user']['last_name'].' '.$_SESSION['user']['name']."',
                `date_create` = NOW()
            ");

            sessionInfo('/admin/static/faq/', $messG['Елемент створено успішно!'], 1);
        }
    }
} elseif(isset($_GET['edit'])) {

    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['question'] = (empty($_POST['question'])? 'class="error"' : '');
        $check['answer'] = (empty($_POST['answer'])? 'class="error"' : '');
        $check['type_faq'] = (!array_key_exists($_POST['type_faq'], $messG['type_faq'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);
            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['sort'] = (!isset($_POST['sort'])? 100 : $_POST['sort']);

            foreach($_POST['img'] as $k => $v){
                if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                    rename($_SERVER['DOCUMENT_ROOT'].$v, $_SERVER['DOCUMENT_ROOT'].'/uploaded/faq/'.basename($v));
                    $image[$k] = '/uploaded/faq/'.basename($v);
                }
            }

            $image = implode('#|#', $image);

            q("
                UPDATE `admin_faq` SET
                `active`    = ".$_POST['active'].",
                `sort`      = ".(int)$_POST['sort'].",
                `type_faq`  = '".$_POST['type_faq']."',
                `question`  = '".$_POST['question']."',
                `answer`    = '".$_POST['answer']."',
                `img`       = '".mres($image)."',
                `user_custom` = '".$_SESSION['user']['last_name'].' '.$_SESSION['user']['name']."',
                `date_custom` = NOW()
                 WHERE `id` = ".(int)$_GET['edit']."
            ");

            sessionInfo('/admin/static/faq/', $messG['Редагування пройшло успішно!'], 1);
        }
    }

    $arResult = q("
            SELECT *
            FROM `admin_faq`
            WHERE `id` = ".(int)$_GET['edit']."
        ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/static/faq/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        $arResult = hsc($arResult->fetch_assoc());

        if(!isset($_POST['img'])){
            $_POST['img'] = explode('#|#', $arResult['img']);
        }
    }
} else {
    if(isset($_GET['ajax'], $_GET['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_faq', '/admin/static/faq/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_faq', '/admin/static/faq/', array(
            $messG['Редагування пройшло успішно!'],
            $mess['У вас недостатньо прав для редагування цього користувача!']
        ));
    } elseif(isset($_GET['delete']) || isset($_POST['delete'])) { // Delete
        // No update admin №1
        if($_SESSION['user']['id'] != 1 && in_array(1, $_POST['ids'])){
            sessionInfo($url, $mess['У вас недостатньо прав для редагування цього користувача!']);
        }

        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_GET['delete']);
        if($ids != $messG['Видалити']){
            AdminFunction::deleteEl($ids, 'admin_faq', '/admin/static/faq/', $messG['Видалення пройшло успішно!']);
        }
    } elseif(isset($_POST['deactivate']) && isset($_POST['ids'])) { // Deactivate
        // No update admin №1
        if($_SESSION['user']['id'] != 1 && in_array(1, $_POST['ids'])){
            sessionInfo($url, $mess['У вас недостатньо прав для редагування цього користувача!']);
        }
        AdminFunction::deactivateEl(implode(',', $_POST['ids']), 'admin_faq', '/admin/static/faq/', $messG['Деактивація пройшла успішно!']);
    } elseif(isset($_POST['activate']) && isset($_POST['ids'])) { // Activate
        AdminFunction::activeEl(implode(',', $_POST['ids']), 'admin_faq', '/admin/static/faq/', $messG['Активація пройшла успішно!']);
    }

    // Filter
    if(isset($_GET['filterReset'])){
        header('Location: /admin/static/faq/');
    }

    $users_list = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_faq",
        'url'        => "/admin/static/faq/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}