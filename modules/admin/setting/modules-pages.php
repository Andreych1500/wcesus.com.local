<?php
if(isset($_REQUEST['add'])){
    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['module'] = (empty($_POST['module'])? 'class="error"' : '');

        $primary = q("
            SELECT `module`
            FROM  `admin_module_pages`
            WHERE `module` = '".mres($_POST['module'])."'
            LIMIT 1
        ");

        if($primary->num_rows > 0){
            $check['module'] = 'class="error"';
        }

        // list
        $list_length = (isset($_POST['list_length'])? implode(',', $_POST['list_length']) : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];

            q(" INSERT INTO `admin_module_pages` SET
                `active`       = ".$_POST['active'].",
                `module`       = '".$_POST['module']."',
                `list_length`  = '".$list_length."',
                `user_custom`  = '".mres($_SESSION['user']['last_name'].' '.$_SESSION['user']['name'])."',
                `date_create`  = NOW()
            ");

            sessionInfo('/admin/setting/modules-pages/', $messG['Елемент створено успішно!'], 1);
        }
    }
} elseif(isset($_REQUEST['edit'])) {
    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['module'] = (empty($_POST['module'])? 'class="error"' : '');
        $check['meta_title'] = (count($_POST['list_length']) != count($_POST['meta_title']) || arrOneEmpty($_POST['meta_title'])? 'class="error"' : '');
        $check['meta_keywords'] = (count($_POST['list_length']) != count($_POST['meta_keywords']) || arrOneEmpty($_POST['meta_keywords'])? 'class="error"' : '');
        $check['meta_description'] = (count($_POST['list_length']) != count($_POST['meta_description']) || arrOneEmpty($_POST['meta_description'])? 'class="error"' : '');

        $primary = q("
            SELECT `module`
            FROM  `admin_module_pages`
            WHERE `module` = '".mres($_POST['module'])."' AND `id` != ".(int)$_REQUEST['edit']."
            LIMIT 1
        ");

        if($primary->num_rows > 0){
            $check['module'] = 'class="error"';
        }

        // list
        $list_length = (isset($_POST['list_length'])? implode(',', $_POST['list_length']) : '');
        $meta_title = (isset($_POST['meta_title'])? implode('#|#', $_POST['meta_title']) : '');
        $meta_keywords = (isset($_POST['meta_keywords'])? implode('#|#', $_POST['meta_keywords']) : '');
        $meta_description = (isset($_POST['meta_description'])? implode('#|#', $_POST['meta_description']) : '');

        // Photo
        $og_image = ((isset($_POST['og_image']))? explode('|', $_POST['og_image']) : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['detail_page'] = !isset($_POST['detail_page'])? 0 : (int)$_POST['detail_page'];
            $_POST['dinamic_page'] = !isset($_POST['dinamic_page'])? 0 : (int)$_POST['dinamic_page'];
            $_POST['open_graph_page'] = !isset($_POST['open_graph_page'])? 0 : (int)$_POST['open_graph_page'];

            q(" UPDATE `admin_module_pages` SET
                `active`           = ".$_POST['active'].",
                `module`           = '".$_POST['module']."',
                `detail_page`      = '".$_POST['detail_page']."',
                `dinamic_page`     = '".$_POST['dinamic_page']."',
                `list_length`      = '".mres($list_length)."',
                `meta_title`       = '".mres($meta_title)."',
                `meta_keywords`    = '".mres($meta_keywords)."',
                `meta_description` = '".mres($meta_description)."',
                `open_graph_page`  = '".$_POST['open_graph_page']."',
                `og_type`          = '".$_POST['og_type']."',
                `og_url`          = '".$_POST['og_url']."',
                `og_image`           = '".mres($og_image[0])."',
                `user_custom`  = '".mres($_SESSION['user']['last_name'].' '.$_SESSION['user']['name'])."'
                WHERE `id` = ".(int)$_REQUEST['edit']."
            ");

            sessionInfo('/admin/setting/modules-pages/', $messG['Редагування пройшло успішно!'], 1);
        }
    }

    $arResult = q("
        SELECT *
        FROM `admin_module_pages`
        WHERE `id` = ".(int)$_REQUEST['edit']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/setting/modules-pages/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        $arResult = $arResult->fetch_assoc();
    }
} else {
    if(isset($_REQUEST['ajax'], $_REQUEST['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_module_pages', '/admin/setting/modules-pages/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_module_pages', '/admin/setting/modules-pages/', $messG['Редагування пройшло успішно!']);
    } elseif(isset($_REQUEST['delete']) || isset($_POST['delete'])) { // Delete
        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_REQUEST['delete']);

        if($ids != $messG['Видалити']){
            AdminFunction::deleteEl($ids, 'admin_module_pages', '/admin/setting/modules-pages/', $messG['Видалення пройшло успішно!']);
        }
    } elseif(isset($_POST['deactivate']) && isset($_POST['ids'])) { // Deactivate
        AdminFunction::deactivateEl(implode(',', $_POST['ids']), 'admin_module_pages', '/admin/setting/modules-pages/', $messG['Деактивація пройшла успішно!']);
    } elseif(isset($_POST['activate']) && isset($_POST['ids'])) { // Activate
        AdminFunction::activeEl(implode(',', $_POST['ids']), 'admin_module_pages', '/admin/setting/modules-pages/', $messG['Активація пройшла успішно!']);
    }

    // Filter
    if(isset($_REQUEST['filterReset'])){
        header('Location: /admin/setting/modules-pages/');
    }

    $module_pages = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_module_pages",
        'url'        => "/admin/setting/modules-pages/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}