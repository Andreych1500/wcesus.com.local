<?php
if(isset($_POST['ok'], $_POST['email'])){
    $error = array();
    $_POST = trimAll($_POST);

    $check['email'] = (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)? 'class="error"' : '');

    if(in_array('class="error"', $check)){
        $error['stop'] = 1;
    }

    if(!count($error)){
        $_POST = mres($_POST);

        $getId = q("
            SELECT * 
            FROM `admin_application_info`
            WHERE `email` = '".$_POST['email']."'
            AND `active` = 1
            AND `access` = 1
            LIMIT 1
        ");

        if($getId->num_rows > 0){
            $arResult = hsc($getId->fetch_assoc());

            $new_password = generationPass();

            q("
                UPDATE `admin_application_info` SET
                `password` = '".myHash($new_password)."'
                WHERE `idCard` = '".mres($arResult['idCard'])."'
                LIMIT 1
            ");

            $set = array(
                'new_password' => $new_password
            );

            Mail::$text = TemplateMail::HtmlMail($set, 'forgot_password', $arMainParam);

            if(Mail::$text){
                Mail::$to = $_POST['email'];
                Mail::send();
            }
            sessionInfo('/cab/', '<p>The operation was successful! На ваш емейл був відправлений лисс з новим паролем довашого кабінету.</p>', 1);
        } else {
            $check['email'] = 'class="error"';
            sessionInfo('/cab/forgot-password/', '<p>Не знайдено жодного запису емейл адреса чи історії платижів з цим адресов.</p>');
        }
    }
}