<?php
if(isset($_POST['ok'])){
    $error = array();
    $_POST = trimAll($_POST);

    $check['phone'] = (empty($_POST['phone'])? 'class="error"' : '');
    $check['email_footer'] = (empty($_POST['email_footer'])? 'class="error"' : '');
    $check['test_email'] = (empty($_POST['test_email']) || !filter_var($_POST['test_email'], FILTER_VALIDATE_EMAIL)? 'class="error"' : '');

    if(in_array('class="error"', $check)){
        $error['stop'] = 1;
    }

    if(!count($error)){
        $_POST = mres($_POST);

        q(" UPDATE `admin_setting_mails` SET
            `phone`        = '".$_POST['phone']."',
            `email_footer` = '".$_POST['email_footer']."', 
            `test_email`   = '".$_POST['test_email']."',
            `user_custom`  = '".mres($_SESSION['user']['last_name'].' '.$_SESSION['user']['name'])."'
            WHERE `id` = 1
        ");

        sessionInfo('/admin/setting/setting-mails/', $messG['Редагування пройшло успішно!'], 1);
    }
}

$arResult = q("
    SELECT * 
    FROM `admin_setting_mails`
    WHERE `id` = 1
")->fetch_assoc();