<?php
$keyPost = ApplyCard::param(4, array('keyPost'));
$param = array_merge(ApplyCard::param(4), ApplyCard::param('glob', array(
    'ap_country',
    'ap_state'
)));
unset($param['ap_country']['USA']);

if(isset($_POST['ok'], $_POST['ap_mailing_us'], $_POST['ap_mailing_all'], $_POST['update'])){
    $error = array();
    $_POST = trimAll($_POST);

    if(!$data = ApplyCard::checkData()){
        sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
    }

    foreach($keyPost['keyPost'] as $v){
        if($v == 'ap_mailing' || $v == 'ap_liability'){
            continue;
        }

        if(!array_key_exists($v, $_POST)){
            $check[$v] = 'class="error"';
            break;
        }
    }

    if(isset($check)){
        $error['stop'] = 1;
    } else {
        $check['applicant_copy'] = (empty($_POST['applicant_copy']) || !isset($param['applicant_copy'][$_POST['applicant_copy']])? 'class="error"' : '');
        $check['ap_institution'] = (empty($_POST['ap_institution'])? 'class="error"' : '');
        $check['ap_attention_to'] = (empty($_POST['ap_attention_to'])? 'class="error"' : '');
        $check['ap_department'] = (empty($_POST['ap_department'])? 'class="error"' : '');
        $check['ap_address1'] = (empty($_POST['ap_address1'])? 'class="error"' : '');
        $check['ap_address2'] = (empty($_POST['ap_address2'])? 'class="error"' : '');
        $check['ap_city'] = (empty($_POST['ap_city'])? 'class="error"' : '');
        $check['ap_liability'] = (!isset($_POST['ap_liability']) || $_POST['ap_liability'] != 1? 'class="error"' : '');
        $check['ap_mailing_us'] = (empty($_POST['ap_mailing_us']) || !isset($param['ap_mailing_us'][$_POST['ap_mailing_us']])? 'class="error"' : '');
        $check['ap_mailing_all'] = (empty($_POST['ap_mailing_all']) || !isset($param['ap_mailing_all'][$_POST['ap_mailing_all']])? 'class="error"' : '');

        if(!preg_match('#^(\d{3})-(\d{3})-(\d{4})$#uis', $_POST['ap_phone'], $matches)){
            $check['ap_phone'] = 'class="error"';
        }

        if($_POST['applicant_copy'] == 2){
            $check['ap_region'] = (empty($_POST['ap_region'])? 'class="error"' : '');
            $check['ap_postal_code'] = (empty($_POST['ap_postal_code'])? 'class="error"' : '');
            $check['ap_country'] = (empty($_POST['ap_country']) || !isset($param['ap_country'][$_POST['ap_country']])? 'class="error"' : '');

            $_POST['ap_state'] = '';
            $_POST['ap_zip_code'] = '';
        } elseif($_POST['applicant_copy'] == 1) {
            $check['ap_state'] = (empty($_POST['ap_state']) || !isset($param['ap_state'][$_POST['ap_state']])? 'class="error"' : '');
            $check['ap_zip_code'] = (empty($_POST['ap_zip_code'])? 'class="error"' : '');

            $_POST['ap_region'] = '';
            $_POST['ap_postal_code'] = '';
        }

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }
    }

    if(!count($error)){
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

            $country = ($_POST['applicant_copy'] == 1? 'USA' : $_POST['ap_country']);
            $ap_mailing = ($_POST['applicant_copy'] == 1? $_POST['ap_mailing_us'] : $_POST['ap_mailing_all']);

            q("
                UPDATE `steps_ok_cards` SET
                `step4`   = 1
                WHERE `idCard` = '".mres($data['idCard'])."'
            ");

            q("
                UPDATE `admin_application_info` SET
                `applicant_copy`    = '".$_POST['applicant_copy']."',
                `ap_institution`    = '".$_POST['ap_institution']."',
                `ap_attention_to`   = '".$_POST['ap_attention_to']."',
                `ap_department`     = '".$_POST['ap_department']."',
                `ap_address1`       = '".$_POST['ap_address1']."',
                `ap_address2`       = '".$_POST['ap_address2']."',
                `ap_city`           = '".$_POST['ap_city']."',
                `ap_region`         = '".$_POST['ap_region']."',
                `ap_phone`          = '".$_POST['ap_phone']."',
                `ap_country`        = '".$country."',
                `ap_state`          = '".$_POST['ap_state']."',
                `ap_zip_code`       = '".$_POST['ap_zip_code']."',
                `ap_postal_code`      = '".$_POST['ap_postal_code']."',
                `ap_mailing`          = ".(int)$ap_mailing.",
                `ap_liability`        = 1,
                `agent`               = '".mres($_SERVER['HTTP_USER_AGENT'])."',
                `user_ip`             = '".mres($_SERVER['REMOTE_ADDR'])."',
                `date_custom`         = NOW()
                WHERE `id` = '".(int)$el['id']."'
            ");

            setcookie('idCardHash', $el['idCardHash'], time() + 3600, '/');
            header('Location: '.(isset($_REQUEST['review'])? '/apply/review/' : '/apply/services/').'');
            exit();
        } else {
            sessionInfo('/apply/mailing/', '<p>WCES ID does not exist!</p>', 0, 0);
        }
    }
}

if(isset($_POST['add_copy'], $_POST['text_copy'], $_POST['mailing_copy'])){
    $error = array();
    $_POST = trimAll($_POST);

    if(!$data = ApplyCard::checkData()){
        sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
    }

    $check['text_copy'] = (empty($_POST['text_copy'])? 'error' : '');
    $check['mailing_copy'] = (empty($_POST['mailing_copy']) || !isset($param['mailing_copy'][$_POST['mailing_copy']])? 'class="error"' : '');

    if(in_array('class="error"', $check) || in_array('error', $check)){
        $error['stop'] = 1;
    }

    if(!count($error)){
        $_POST = mres($_POST);

        $card = q("
            SELECT `id`, `idCard`, `idCardHash`
            FROM `admin_application_info`
            WHERE `id` = '".$_POST['update']."'
            AND `idCardHash` = '".mres($data['idCardHash'])."'
            LIMIT 1
        ");

        if(isset($_REQUEST['edit']) && $card->num_rows > 0){
            $arResult = hsc($card->fetch_assoc());

            q("
                UPDATE `admin_official_agency_copy` SET
                `text_copy`    = '".$_POST['text_copy']."',
                `mailing_copy` = '".$_POST['mailing_copy']."'
                WHERE `id`   = '".mres($_REQUEST['edit'])."'
                AND `idCard` = '".mres($arResult['idCard'])."'
            ");

            setcookie('idCardHash', $arResult['idCardHash'], time() + 3600, '/');
            header('Location: /apply/mailing/');
            exit();
        } elseif(isset($_REQUEST['edit']) && $card->num_rows <= 0) {
            sessionInfo('/apply/mailing/', '<p>Wrong WCES ID, access denied!</p>');
        }

        if($card->num_rows <= 0){
            sessionInfo('/apply/mailing/', '<p>Wrong WCES ID, linking is forbidden!</p>', 0, 0);
        } else {
            $arResult = hsc($card->fetch_assoc());

            $count = q("
                SELECT *
                FROM `admin_official_agency_copy`
                WHERE `idCard` = '".mres($arResult['idCard'])."'
            ");

            if($count->num_rows >= 4){
                sessionInfo('/apply/mailing/', '<p>You have reached 4 copies limit!</p>');
            }

            q("
                INSERT INTO `admin_official_agency_copy` SET
                    `idCard`       = '".mres($arResult['idCard'])."',
                    `text_copy`    = '".$_POST['text_copy']."',
                    `mailing_copy` = '".$_POST['mailing_copy']."',
                    `date_create`  = NOW()
            ");

            setcookie('idCardHash', $arResult['idCardHash'], time() + 3600, '/');
            header('Location: /apply/mailing/');
            exit();
        }
    }
}

if($data = ApplyCard::checkData()){
    foreach($data as $k => $v){
        if(in_array($k, $keyPost['keyPost']) && !isset($_POST[$k])){
            $_POST[$k] = $v;
        }
    }

    if($_POST['applicant_copy'] == 1){
        $_POST['ap_mailing_us'] = $_POST['ap_mailing'];
    } else {
        $_POST['ap_mailing_all'] = $_POST['ap_mailing'];
    }

    $_POST['update'] = $data['id'];

    $oac = q("
        SELECT * 
        FROM `admin_official_agency_copy`
        WHERE `idCard` = '".mres($data['idCard'])."'
    ");
} else {
    sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
}

if(isset($_GET['edit'])){
    $oacEd = q("
        SELECT *
        FROM `admin_official_agency_copy`
        WHERE `idCard` = '".mres($data['idCard'])."'
        AND `id` = '".mres($_GET['edit'])."'
        LIMIT 1
    ");

    if($oacEd->num_rows > 0){
        foreach(hsc($oacEd->fetch_assoc()) as $k => $v){
            $_POST[$k] = $v;
        }
    } else {
        sessionInfo('/apply/mailing/', '<p>There is no such paper copies of your application!</p>');
    }
}

if(isset($_GET['remove'])){
    q("
        DELETE FROM `admin_official_agency_copy`
        WHERE `id` = ".(int)$_GET['remove']."
        AND `idCard` = '".mres($data['idCard'])."'
    ");

    header('Location: /apply/mailing/');
    exit();
}

Core::$JS[] = "<script src=\"/skins/default/js/mailing.min.js\" defer></script>";