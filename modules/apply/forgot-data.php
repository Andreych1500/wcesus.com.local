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

        $getCard = q("
            SELECT *
            FROM `admin_application_info`
            WHERE `email` = '".$_POST['email']."'
            LIMIT 1
        ");

        if($getCard->num_rows > 0){
            $arResult = hsc($getCard->fetch_assoc());

            $set = array(
                'idCard'    => $arResult['idCard'],
                'email'     => $_POST['email'],
                'date_mm'   => $arResult['date_mm'],
                'date_dd'   => $arResult['date_dd'],
                'date_yyyy' => $arResult['date_yyyy']
            );

            Mail::$text = TemplateMail::HtmlMail($set, 'forgot-data', $arMainParam);

            if(Mail::$text){
                Mail::$to = $_POST['email'];
                Mail::send();
            }

            sessionInfo('/apply/', '<p>The operation was successful! You sent a letter of access to your private profiles, please check the it.</p>', 1);
        } else {
            $check['email'] = 'class="error"';
        }
    }
}
