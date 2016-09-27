<?php
if(isset($_POST['ok'], $_POST['end_comment'], $_POST['update'])){
    $error = array();
    $_POST = trimAll($_POST);

    if(!$data = ApplyCard::checkData()){
        sessionInfo('/cab/apply-user/', '<p>час зберігання даних вийшов, увійдіть знов у свій кабінет і заповніть дані!</p>');
    }

   if(!empty($_POST['end_comment'])){
       $_POST = mres($_POST);

       $id = q("
            SELECT `id`, `idCardHash`
            FROM `admin_application_info`
            WHERE `id` = '".$_POST['update']."'
            AND `idCardHash` = '".mres($_COOKIE['idCardHash'])."'
            LIMIT 1
        ");

       if($id->num_rows > 0){
           $el = hsc($id->fetch_assoc());

           q("
                UPDATE `admin_application_info` SET
                `end_comment`  = '".$_POST['end_comment']."',
                `agent`        = '".mres($_SERVER['HTTP_USER_AGENT'])."',
                `user_ip`      = '".mres($_SERVER['REMOTE_ADDR'])."',
                `date_custom`  = NOW()
                WHERE `id` = '".(int)$el['id']."'
            ");

           setcookie('idCardHash', $el['idCardHash'], time() + 3600, '/');
           header('Location: /cab/review/');
           exit();
       } else {
           sessionInfo('/cab/review/', '<p>Такого ід не існує!</p>', 0, 0);
       }
   }
}

if($data = ApplyCard::checkData()){
    $arResult = array();

    for($i = 1; $i < 7; ++$i){
        if($i == 2){
            continue;
        }

        $field = ApplyCard::param($i, 'globPost');
        $arField = ApplyCard::param($i);

        foreach($field as $v){
            if($v == 'admission_to' || $v == 'admission_ap_pur'){
                if(!empty($data[$v])){
                    foreach(explode(',', $data[$v]) as $k2){
                        $arResult[$v][$k2] = $arField[$v][$k2];
                    }
                } else {
                    $arResult[$v] = '';
                }
                continue;
            }

            if($v == 'ap_mailing'){
                if(strlen($data[$v]) > 0){
                    if($data[$v] == 1){
                        $arResult[$v] = $arField['ap_mailing_us'][$data[$v]];
                    } else {
                        $arResult[$v] = $arField['ap_mailing_all'][$data[$v]];
                    }
                } else {
                    $arResult[$v] = '';
                }

                continue;
            }

            if($v == 'report_type'){
                if(strlen($data[$v]) > 0){
                    $arResult[$v] = $arField[$v][$data[$v]];
                } else {
                    $arResult[$v] = '';
                }

                continue;
            }

            if($v == 'ap_country' && $data[$v] == 'USA'){
                $arResult[$v] = $data[$v];
                continue;
            }

            if(isset($arField[$v])){
                $arResult[$v] = $arField[$v][$data[$v]];
            } else {
                $arResult[$v] = $data[$v];
            }
        }
    }

    // ap Address
    $apAddress = array($arResult['ap_country'], $arResult['ap_state'], $arResult['ap_region'], $arResult['ap_address1'], $arResult['ap_address2'], $arResult['ap_city'], $arResult['ap_zip_code'], $arResult['ap_postal_code']);
    $ap_address = '';

    foreach($apAddress as $v){
        $ap_address .= (empty($v)? '' : $v.', ');
    }

    $ap_address = trim($ap_address, ', ');

    $arHistory = q("
        SELECT *
        FROM `admin_educational_history`
        WHERE `idCard` = '".mres($data['idCard'])."'
    ");

    $arAgencyCopy = q("
        SELECT *
        FROM `admin_official_agency_copy`
        WHERE `idCard` = '".mres($data['idCard'])."'
    ");

    if($arAgencyCopy->num_rows > 0){
        $iFeild = ApplyCard::param(4, 'mailing_copy');
        $price = 0;

        while($copy = hsc($arAgencyCopy->fetch_assoc())){
            $price += (int)$iFeild[$copy['mailing_copy']]['price'];
        }
    }

    $arAgencyCopy->data_seek(0);

    $_POST['update'] = $data['id'];
} else {
    sessionInfo('/cab/apply-user/', '<p>Щоб перейти у цей розділ розпочніть нову анкету або продовжіть існуючу, або час очікування закінчився.</p>');
}