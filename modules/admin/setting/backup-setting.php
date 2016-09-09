<?php
if(isset($_REQUEST['backup-setting'])){

    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['name_db'] = (empty($_POST['name_db'])? 'class="error"' : '');
        $check['unset_dir_to_zip'] = (empty($_POST['unset_dir_to_zip'])? 'class="error"' : '');
        $check['time_delete_zip'] = (empty($_POST['time_delete_zip'])? 'class="error"' : '');
        $check['name_prefix_dir_zip'] = (empty($_POST['name_prefix_dir_zip'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            q(" UPDATE `admin_backup_setting` SET
                `name_db`              = '".$_POST['name_db']."',
                `unset_dir_to_zip`     = '".$_POST['unset_dir_to_zip']."',
                `time_delete_zip`      = '".(int)$_POST['time_delete_zip']."',
                `name_prefix_dir_zip`  = '".$_POST['name_prefix_dir_zip']."',
                `user_custom`          = '".mres($_SESSION['user']['last_name'].' '.$_SESSION['user']['name'])."'
            ");

            sessionInfo('/admin/setting/backup-setting/', $messG['Редагування пройшло успішно!'], 1);
        } else {
            sessionInfo('/admin/setting/backup-setting/', $mess['Сталася помилка, не заповнено коректно поля!']);
        }
    }

    $arResult = q("
        SELECT * 
        FROM `admin_backup_setting`
    ")->fetch_assoc();
} else {

    $arResult = hsc(q("
        SELECT * 
        FROM `admin_backup_setting`
    ")->fetch_assoc());
}