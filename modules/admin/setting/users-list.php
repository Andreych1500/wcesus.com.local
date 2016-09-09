<?php
if(isset($_REQUEST['add'])){
    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['name'] = (empty($_POST['name'])? 'class="error"' : '');
        $check['last_name'] = (empty($_POST['last_name'])? 'class="error"' : '');
        $check['login'] = ((empty($_POST['login']) || strlen($_POST['login']) < 6)? 'class="error"' : '');
        $check['email'] = ((empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))? 'class="error"' : '');
        $check['pass'] = ((empty($_POST['pass']) || strlen($_POST['pass']) < 6)? 'class="error"' : '');
        $check['check_pass'] = ((empty($_POST['check_pass']) || $_POST['pass'] != $_POST['check_pass'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        } else {
            $res = q("
			          SELECT `id`
			          FROM  `admin_users_list`
			          WHERE `login` = '".mres($_POST['login'])."'
			          OR `email` = '".mres($_POST['email'])."'
                LIMIT 1
            ");

            if($res->num_rows){
                $error['stop'] = 1;
                sessionInfo('/admin/setting/users-list/?add='.$_REQUEST['add'], $messG['Користувач з таким логіном або Email вже існує!'], 0, 0);
            }
        }

        if(!count($error)){
            $_POST = mres($_POST);
            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['sort'] = (!isset($_POST['sort'])? 100 : $_POST['sort']);
            $active_url = (!$_POST['active']? '&active=ok&' : '&');

            $arImage = array(
                'user_avatar'  => $_POST['user_avatar'],
            );

            foreach($arImage as $k => $v){
                if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                    rename($_SERVER['DOCUMENT_ROOT'].$v, $_SERVER['DOCUMENT_ROOT'].'/uploaded/users/'.basename($v));
                    $_POST[$k] = '/uploaded/users/'.basename($v);
                }
            }

            q("
                INSERT INTO `admin_users_list` SET
                `access`      = ".(int)$_POST['access'].",
                `sort`        = ".(int)$_POST['sort'].",
                `active`      = ".$_POST['active'].",
                `name`        = '".$_POST['name']."',
                `last_name`   = '".$_POST['last_name']."',
                `end_name`    = '".$_POST['end_name']."',
                `login`       = '".$_POST['login']."',
                `email`       = '".$_POST['email']."',
                `pass`        = '".myHash($_POST['pass'])."',
                `hash`        = '".myHash($_POST['login'].$_POST['pass'].$_POST['email'])."',
                `user_avatar` = '".$_POST['user_avatar']."',
                `age`         = '".(int)$_POST['age']."',
                `phone`       = '".$_POST['phone']."',
                `profession`  = '".$_POST['profession']."',
                `web_site`    = '".$_POST['web_site']."',
                `floor`       = '".(int)$_POST['floor']."',
                `country`     = '".$_POST['country']."',
                `region`      = '".$_POST['region']."',
                `city`        = '".$_POST['city']."',
                `user_custom` = '".$_SESSION['user']['last_name'].' '.$_SESSION['user']['name']."',
                `date_create` = NOW()
            ");

            if(isset($_POST['male']) && (int)$_POST['access'] == 1){
                $id = DB::_()->insert_id;

                $param = array(
                    'login'    => $_POST['login'],
                    'pass'     => $_POST['pass'],
                    'email'    => $_POST['email'],
                    'link_act' => $arMainParam['url_http_site'].'/cab/activate/?id='.(int)$id.$active_url.'hash='.urlencode(myHash($_POST['login'].$_POST['pass'].$_POST['email']))
                );

                Mail::$text = TemplateMail::HtmlMail($param, $_POST['code_mails'], $arMainParam);

                if(Mail::$text){
                    Mail::$to = $_POST['email'];
                    Mail::send();
                }
            }

            sessionInfo('/admin/setting/users-list/', $messG['Елемент створено успішно!'], 1);
        }
    }

    $list = q("
        SELECT `symbol_code`
        FROM `admin_type_mails`
        WHERE `symbol_code` LIKE 'registration_user_%'
    ");
} elseif(isset($_REQUEST['edit'])) {

    if($_REQUEST['edit'] == 1 && $_SESSION['user']['id'] != 1){
        sessionInfo('/admin/setting/users-list/', $mess['У вас недостатньо прав для редагування цього користувача!']);
    }

    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['name'] = (empty($_POST['name'])? 'class="error"' : '');
        $check['last_name'] = (empty($_POST['last_name'])? 'class="error"' : '');
        $check['login'] = ((empty($_POST['login']) || strlen($_POST['login']) < 6)? 'class="error"' : '');
        $check['email'] = ((empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))? 'class="error"' : '');
        $check['new_pass'] = ((isset($_POST['new_pass']) && strlen($_POST['new_pass']) < 6 && strlen($_POST['new_pass']) > 0)? 'class="error"' : '');
        $check['check_pass'] = ((isset($_POST['check_pass']) && $_POST['new_pass'] != $_POST['check_pass'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        } else {
            $res = q("
			          SELECT `id`
			          FROM  `admin_users_list`
			          WHERE `id` != ".(int)$_REQUEST['edit']."
			          AND (`login` = '".mres($_POST['login'])."' OR `email` = '".mres($_POST['email'])."')
            ");

            if($res->num_rows){
                $error['stop'] = 1;
                sessionInfo('/admin/setting/users-list/?edit='.$_REQUEST['edit'], $messG['Користувач з таким логіном або Email вже існує!'], 0, 0);
            }
        }

        if(!count($error)){
            $_POST = mres($_POST);
            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['sort'] = (!isset($_POST['sort'])? 100 : $_POST['sort']);

            $new_pass = !empty($_POST['new_pass']) && isset($_POST['new_pass'])? "`pass` = '".myHash($_POST['new_pass'])."', `hash` = '".myHash($_POST['login'].$_POST['new_pass'].$_POST['email'])."'," : '';

            $arImage = array(
                'user_avatar'  => $_POST['user_avatar'],
            );

            foreach($arImage as $k => $v){
                if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                    rename($_SERVER['DOCUMENT_ROOT'].$v, $_SERVER['DOCUMENT_ROOT'].'/uploaded/users/'.basename($v));
                    $_POST[$k] = '/uploaded/users/'.basename($v);
                }
            }

            q("
                UPDATE `admin_users_list` SET
                `access`      = ".(int)$_POST['access'].",
                `active`      = ".$_POST['active'].",
                `sort`        = ".(int)$_POST['sort'].",
                `name`        = '".$_POST['name']."',
                `last_name`   = '".$_POST['last_name']."',
                `end_name`    = '".$_POST['end_name']."',
                `login`       = '".$_POST['login']."',
                `email`       = '".$_POST['email']."',
                 ".$new_pass."
                `user_avatar` = '".$_POST['user_avatar']."',
                `age`         = '".(int)$_POST['age']."',
                `phone`       = '".$_POST['phone']."',
                `profession`  = '".$_POST['profession']."',
                `web_site`    = '".$_POST['web_site']."',
                `floor`       = '".(int)$_POST['floor']."',
                `country`     = '".$_POST['country']."',
                `region`      = '".$_POST['region']."',
                `city`        = '".$_POST['city']."',
                `user_custom` = '".$_SESSION['user']['last_name'].' '.$_SESSION['user']['name']."',
                `date_custom` = NOW()
                 WHERE `id` = ".(int)$_REQUEST['edit']."
            ");

            sessionInfo('/admin/setting/users-list/', $messG['Редагування пройшло успішно!'], 1);
        }
    }

    $arResult = q("
        SELECT *
        FROM `admin_users_list`
        WHERE `id` = ".(int)$_REQUEST['edit']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/setting/users-list/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        $arResult = hsc($arResult->fetch_assoc());
    }
} else {
    if(isset($_REQUEST['ajax'], $_REQUEST['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_users_list', '/admin/setting/users-list/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_users_list', '/admin/setting/users-list/', array(
            $messG['Редагування пройшло успішно!'],
            $mess['У вас недостатньо прав для редагування цього користувача!']
        ));
    } elseif(isset($_REQUEST['delete']) || isset($_POST['delete'])) { // Delete
        // No update admin №1
        if($_SESSION['user']['id'] != 1 && in_array(1, $_POST['ids'])){
            sessionInfo($url, $mess['У вас недостатньо прав для редагування цього користувача!']);
        }

        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_REQUEST['delete']);
        if($ids != $messG['Видалити']){
            AdminFunction::deleteEl($ids, 'admin_users_list', '/admin/setting/users-list/', $messG['Видалення пройшло успішно!']);
        }
    } elseif(isset($_POST['deactivate']) && isset($_POST['ids'])) { // Deactivate
        // No update admin №1
        if($_SESSION['user']['id'] != 1 && in_array(1, $_POST['ids'])){
            sessionInfo($url, $mess['У вас недостатньо прав для редагування цього користувача!']);
        }
        AdminFunction::deactivateEl(implode(',', $_POST['ids']), 'admin_users_list', '/admin/setting/users-list/', $messG['Деактивація пройшла успішно!']);
    } elseif(isset($_POST['activate']) && isset($_POST['ids'])) { // Activate
        AdminFunction::activeEl(implode(',', $_POST['ids']), 'admin_users_list', '/admin/setting/users-list/', $messG['Активація пройшла успішно!']);
    }

    // Filter
    if(isset($_REQUEST['filterReset'])){
        header('Location: /admin/setting/users-list/');
    }

    $users_list = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_users_list",
        'url'        => "/admin/setting/users-list/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}