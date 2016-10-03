<?php
$keyPost = ApplyCard::param(3, array('keyPost'));
$param = ApplyCard::param(3);

if(isset($_POST['ok'], $_POST['update'])){
    $error = array();
    $_POST = trimAll($_POST);

    if(!$data = ApplyCard::checkData()){
        sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
    }

    foreach($keyPost['keyPost'] as $v){
        if($v == 'admission_ap_pur' || $v == 'admission_to'){
            if(!isset($_POST[$v])){
                $_POST[$v] = array();
            } else {
                continue;
            }
        }

        if(!array_key_exists($v, $_POST)){
            $check[$v] = 'class="error"';
            break;
        }
    }

    if(isset($check)){
        $error['stop'] = 1;
    } else {
        $check['main_purpose'] = (empty($_POST['main_purpose']) || !isset($param['main_purpose'][$_POST['main_purpose']])? 'class="error"' : '');

        if($_POST['main_purpose'] == 1){
            $check['admission_to'] = (count($_POST['admission_to']) <= 0 || arrayNotKey($_POST['admission_to'], $param['admission_to'])? 'class="error"' : '');
        } elseif($_POST['main_purpose'] == 4) {
            $check['please_spec'] = (empty($_POST['please_spec'])? 'class="error"' : '');
        }

        $check['admission_ap_pur'] = (count($_POST['admission_ap_pur']) > 0 && arrayNotKey($_POST['admission_ap_pur'], $param['admission_ap_pur'])? 'class="error"' : '');

        if(count($_POST['admission_ap_pur']) > 0 && in_array($_POST['main_purpose'], $_POST['admission_ap_pur'])){
            $_POST['admission_ap_pur'] = array();
            $check['admission_ap_pur'] = 'class="error"';
        }

        if($_POST['main_purpose'] != 1){
            $_POST['admission_to'] = array();
        }

        if($_POST['main_purpose'] != 4){
            $_POST['please_spec'] = '';
        }

        $check['document_requirements'] = (empty($_POST['document_requirements']) || !isset($param['document_requirements'][$_POST['document_requirements']])? 'class="error"' : '');

        $check['report_type'] = (count($_POST['report_type']) <= 0 || arrayNotKey($_POST['report_type'], $param['report_type'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }
    }

    if(!count($error)){
        $_POST = mres($_POST);

        if(isset($_POST['update'])){
            $id = q("
                SELECT `id`, `idCardHash`
                FROM `admin_application_info`
                WHERE `id` = '".$_POST['update']."'
                AND `idCardHash` = '".mres($_COOKIE['idCardHash'])."'
                LIMIT 1
            ");

            if($id->num_rows > 0){
                $el = hsc($id->fetch_assoc());

                $_POST['admission_ap_pur'] = trim(implode(',', $_POST['admission_ap_pur']), ',');
                $_POST['admission_to'] = trim(implode(',', $_POST['admission_to']), ',');

                q("
                    UPDATE `steps_ok_cards` SET
                    `step3`   = 1
                    WHERE `idCard` = '".mres($data['idCard'])."'
                ");

                q("
                    UPDATE `admin_application_info` SET
                    `main_purpose`          = '".$_POST['main_purpose']."',
                    `please_spec`           = '".$_POST['please_spec']."',
                    `admission_to`          = '".$_POST['admission_to']."',
                    `document_requirements` = '".$_POST['document_requirements']."',
                    `report_type`           = '".current($_POST['report_type'])."',
                    `admission_ap_pur`      = '".$_POST['admission_ap_pur']."',
                    `agent`           = '".mres($_SERVER['HTTP_USER_AGENT'])."',
                    `user_ip`         = '".mres($_SERVER['REMOTE_ADDR'])."',
                    `date_custom`     = NOW()
                    WHERE `id` = '".(int)$el['id']."'
                ");

                setcookie('idCardHash', $el['idCardHash'], time() + 3600, '/');
                header('Location: '.(isset($_GET['review'])? '/apply/review/' : '/apply/mailing/').'');
                exit();
            } else {
                sessionInfo('/apply/purpose/', '<p>WCES ID does not exist!</p>', 0, 0);
            }
        }
    }
}

if($data = ApplyCard::checkData()){
    foreach($data as $k => $v){
        if(in_array($k, $keyPost['keyPost']) && !isset($_POST[$k])){
            if($k == 'admission_to' || $k == 'admission_ap_pur'){
                $_POST[$k] = explode(',', $v);
            } elseif($k == 'report_type') {
                $_POST[$k] = array($v);
            } else {
                $_POST[$k] = $v;
            }
        }
    }

    $_POST['update'] = $data['id'];
} else {
    sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
}

Core::$JS[] = "<script src=\"/skins/default/js/purpose.min.js\" defer></script>";