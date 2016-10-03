<?php
$param = ApplyCard::param('glob');

for($i = 1; $i < 7; ++$i){
    if($i == 2){
        continue;
    }
    $param = array_merge($param, ApplyCard::param($i));
}

if(isset($_POST['ok'], $_POST['end_comment'], $_POST['update'])){
    $error = array();
    $_POST = trimAll($_POST);
    $_POST = mres($_POST);

    if(!$data = ApplyCard::checkData()){
        sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
    }

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
        header('Location: /apply/payment/');
        exit();
    } else {
        sessionInfo('/apply/review/', '<p>Wrong WCES ID, access denied!</p>', 0, 0);
    }
}

if($data = ApplyCard::checkData()){
    $arResult = array();

    foreach($data as $k => $v){
        if(isset($param[$k]) && !empty($v)){
            if($k == 'admission_to' || $k == 'admission_ap_pur'){
                foreach(explode(',', $v) as $k2){
                    $arResult[$k][$k2] = $param[$k][$k2];
                }
            } else {
                $arResult[$k] = $param[$k][$v];
            }
        } else {
            if(!empty($v)){
                if($k == 'ap_mailing'){
                    $arResult[$k] = ($data['applicant_copy'] == 1? $param['ap_mailing_us'][$v] : $param['ap_mailing_all'][$v]);
                } else {
                    $arResult[$k] = $v;
                }
            } else {
                $arResult[$k] = '';
            }
        }
    }

    // ap Address
    $apAddress = array(
        $arResult['ap_country'],
        $arResult['ap_state'],
        $arResult['ap_region'],
        $arResult['ap_address1'],
        $arResult['ap_address2'],
        $arResult['ap_city'],
        $arResult['ap_zip_code'],
        $arResult['ap_postal_code']
    );

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
        $price = 0;

        while($copy = hsc($arAgencyCopy->fetch_assoc())){
            $price += (int)$param['mailing_copy'][$copy['mailing_copy']]['price'];
        }
    }

    $arAgencyCopy->data_seek(0);

    $_POST['update'] = $data['id'];
} else {
    sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
}