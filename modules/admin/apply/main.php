<?php
if(isset($_GET['edit'])){
    $keyPost = array();
    $param = ApplyCard::param('glob');
    unset($param['ap_country']['USA']);

    for($i = 1; $i < 7; ++$i){
        if($i == 2){
            continue;
        }
        $param = array_merge($param, ApplyCard::param($i));
        $keyPost = array_merge($keyPost, current(ApplyCard::param($i, array('keyPost'))));
    }

    unset($keyPost[array_search('ap_mailing', $keyPost)]); // Unset mailing

    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        foreach($keyPost as $v){
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
            $check['last_name'] = (empty($_POST['last_name'])? 'class="error"' : '');
            $check['first_name'] = (empty($_POST['first_name'])? 'class="error"' : '');
            $check['is_records_name'] = (empty($_POST['is_records_name']) || !isset($param['is_records_name'][$_POST['is_records_name']])? 'class="error"' : '');
            $check['gender'] = (empty($_POST['gender']) || !isset($param['gender'][$_POST['gender']])? 'class="error"' : '');
            $check['date_mm'] = (empty($_POST['date_mm']) || !isset($param['date_mm'][$_POST['date_mm']])? 'class="error"' : '');
            $check['date_dd'] = (empty($_POST['date_dd']) || !isset($param['date_dd'][$_POST['date_dd']])? 'class="error"' : '');
            $check['date_yyyy'] = (empty($_POST['date_yyyy']) || !isset($param['date_yyyy'][$_POST['date_yyyy']])? 'class="error"' : '');
            $check['email'] = (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)? 'class="error"' : '');
            $check['about_us'] = (empty($_POST['about_us']) || !isset($param['about_us'][$_POST['about_us']])? 'class="error"' : '');
            $check['country'] = (empty($_POST['country']) || !isset($param['country'][$_POST['country']])? 'class="error"' : '');
            $check['services_WCES'] = (empty($_POST['services_WCES']) || !isset($param['services_WCES'][$_POST['services_WCES']])? 'class="error"' : '');
            $check['addressOneLine'] = (empty($_POST['addressOneLine'])? 'class="error"' : '');
            $check['city'] = (empty($_POST['city'])? 'class="error"' : '');
            $check['phone'] = (empty($_POST['phone'])? 'class="error"' : '');

            if($_POST['services_WCES'] == 2){
                $check['old_num_card'] = (empty($_POST['old_num_card']) || strlen($_POST['old_num_card']) < 5? 'class="error"' : '');
            } else {
                $_POST['old_num_card'] = '';
            }

            $email = q("
                SELECT `id`
                FROM `admin_application_info`
                WHERE `email` = '".$_POST['email']."'
                AND `id` != '".$_GET['edit']."'
                LIMIT 1
            ");

            if($email->num_rows > 0){
                $check['email'] = 'class="error"';
            }

            if($_POST['is_records_name'] == 2){
                $check['last_name_records'] = (empty($_POST['last_name_records'])? 'class="error"' : '');
                $check['first_name_records'] = (empty($_POST['first_name_records'])? 'class="error"' : '');
            } else {
                $_POST['last_name_records'] = '';
                $_POST['first_name_records'] = '';
                $_POST['middle_name_records'] = '';
            }

            if($_POST['about_us'] == 7){
                $check['about_us_answer'] = (empty($_POST['about_us_answer'])? 'class="error"' : '');
            } else {
                $_POST['about_us_answer'] = '';
            }

            if($_POST['country'] != 'USA'){
                $check['region'] = (empty($_POST['region'])? 'class="error"' : '');
                $check['postal_code'] = (empty($_POST['postal_code'])? 'class="error"' : '');

                $_POST['state'] = '';
                $_POST['zip_code'] = '';
            } else {
                $check['state'] = (empty($_POST['state']) || !isset($param['state'][$_POST['state']])? 'class="error"' : '');
                $check['zip_code'] = (empty($_POST['zip_code'])? 'class="error"' : '');

                $_POST['region'] = '';
                $_POST['postal_code'] = '';
            }

            $check['main_purpose'] = (empty($_POST['main_purpose']) || !isset($param['main_purpose'][$_POST['main_purpose']])? 'class="error"' : '');

            if($_POST['main_purpose'] == 1){
                $check['admission_to'] = (!isset($_POST['admission_to']) || count($_POST['admission_to']) <= 0 || arrayNotKey($_POST['admission_to'], $param['admission_to'])? 'class="error"' : '');
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

            $check['turnaround_time'] = (!isset($_POST['turnaround_time']) || empty($_POST['turnaround_time']) || !isset($param['turnaround_time'][$_POST['turnaround_time']])? 'class="error"' : '');
        }

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            $_POST['access'] = !isset($_POST['access'])? 0 : (int)$_POST['access'];
            $_POST['payment_ok'] = !isset($_POST['payment_ok'])? 0 : (int)$_POST['payment_ok'];
            $_POST['admission_ap_pur'] = trim(implode(',', $_POST['admission_ap_pur']), ',');
            $_POST['admission_to'] = trim(implode(',', $_POST['admission_to']), ',');
            $country = ($_POST['applicant_copy'] == 1? 'USA' : $_POST['ap_country']);
            $ap_mailing = ($_POST['applicant_copy'] == 1? $_POST['ap_mailing_us'] : $_POST['ap_mailing_all']);

            $price = ApplyCard::getAllPrice($_POST);

            q("
               UPDATE `admin_application_info` SET
                `access`              = ".$_POST['access'].",
                `payment_ok`          = ".$_POST['payment_ok'].",
                `all_price`           = ".mres($price.'.00').",
                `last_name`           = '".$_POST['last_name']."',
                `first_name`          = '".$_POST['first_name']."',
                `middle_name`         = '".$_POST['middle_name']."',
                `is_records_name`     = '".$_POST['is_records_name']."',
                `last_name_records`   = '".$_POST['last_name_records']."',
                `first_name_records`  = '".$_POST['first_name_records']."',
                `middle_name_records` = '".$_POST['middle_name_records']."',
                `gender`              = '".$_POST['gender']."',
                `date_mm`             = '".$_POST['date_mm']."',
                `date_dd`             = '".$_POST['date_dd']."',
                `date_yyyy`           = '".$_POST['date_yyyy']."',
                `phone`               = '".$_POST['phone']."',
                `email`               = '".$_POST['email']."',
                `cell_phone`          = '".$_POST['cell_phone']."',
                `about_us`            = '".$_POST['about_us']."',
                `about_us_answer`     = '".$_POST['about_us_answer']."',
                `country`             = '".$_POST['country']."',
                `services_WCES`       = '".$_POST['services_WCES']."',
                `old_num_card`        = '".$_POST['old_num_card']."',
                `addressOneLine`      = '".$_POST['addressOneLine']."',
                `addressTwoLine`      = '".$_POST['addressTwoLine']."',
                `city`                = '".$_POST['city']."',
                `region`              = '".$_POST['region']."',
                `postal_code`         = '".$_POST['postal_code']."',
                `zip_code`            = '".$_POST['zip_code']."',
                `state`               = '".$_POST['state']."',
                `main_purpose`          = '".$_POST['main_purpose']."',
                `please_spec`           = '".$_POST['please_spec']."',
                `admission_to`          = '".$_POST['admission_to']."',
                `document_requirements` = '".$_POST['document_requirements']."',
                `report_type`           = '".current($_POST['report_type'])."',
                `admission_ap_pur`      = '".$_POST['admission_ap_pur']."',
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
                `ap_mailing`          = '".$ap_mailing."',
                `ap_liability`        = 1,
                `turnaround_time`     = '".$_POST['turnaround_time']."',
                `end_comment`         = '".$_POST['end_comment']."',
                `agent`               = '".mres($_SERVER['HTTP_USER_AGENT'])."',
                `user_ip`             = '".mres($_SERVER['REMOTE_ADDR'])."',
                `date_custom`         = NOW()
                WHERE `id` = '".$_GET['edit']."'
            ");

            sessionInfo('/admin/apply/', $messG['Редагування пройшло успішно!'], 1);
        }
    }

    $arResult = q("
        SELECT *
        FROM `admin_application_info`
        WHERE `id` = ".(int)$_GET['edit']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/apply/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        foreach($arResult->fetch_assoc() as $k => $v){
            if(!isset($_POST[$k])){
                if($k == 'admission_to' || $k == 'admission_ap_pur'){
                    foreach(explode(',', $v) as $k2){
                        $_POST[$k][] = $k2;
                    }
                } elseif($k == 'report_type') {
                    $_POST[$k] = array($v);
                } else {
                    $_POST[$k] = hsc($v);
                }
            }
        }
    }

    if($_POST['applicant_copy'] == 1){
        $_POST['ap_mailing_us'] = $_POST['ap_mailing'];
    } else {
        $_POST['ap_mailing_all'] = $_POST['ap_mailing'];
    }

    $history = q("
        SELECT *
        FROM `admin_educational_history`
        WHERE `idCard` = '".mres($_POST['idCard'])."'
    ");

    $copyAgency = q("
        SELECT *
        FROM `admin_official_agency_copy`
        WHERE `idCard` = ".mres($_POST['idCard'])."
    ");

    Core::$JS[] = '<script src="/skins/admin/js/apply.min.js?v='.$vF.'" defer></script>';
} else {
    if(isset($_GET['ajax'], $_GET['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_application_info', '/admin/apply/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_application_info', '/admin/apply/', $messG['Редагування пройшло успішно!']);
    } elseif(isset($_GET['delete']) || isset($_POST['delete'])) { // Delete
        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_GET['delete']);
        if($ids != $messG['Видалити']){
            $history = q("
                SELECT *
                FROM `admin_educational_history`
                WHERE `idCard` IN
                       (SELECT `idCard`
                        FROM `admin_application_info`
                        WHERE `id` IN (".$ids.")
                        )
            ");

            while($file = $history->fetch_assoc()){
                foreach(explode('#|#', $file['fileScan']) as $k => $v){
                    if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                        unlink($_SERVER['DOCUMENT_ROOT'].$v);
                    }
                }
            }

            q("
                DELETE FROM `admin_educational_history`
                WHERE `idCard` IN
                       (SELECT `idCard`
                        FROM `admin_application_info`
                        WHERE `id` IN (".$ids.")
                )
            ");

            q("
                DELETE FROM `admin_official_agency_copy`
                WHERE `idCard` IN
                (SELECT `idCard`
                        FROM `admin_application_info`
                        WHERE `id` IN (".$ids.")
                )
            ");

            q("
                DELETE FROM `admin_cab_copy_info`
                WHERE `idCard` IN
                (SELECT `idCard`
                        FROM `admin_application_info`
                        WHERE `id` IN (".$ids.")
                )
            ");

            q("
                DELETE FROM `steps_ok_cards`
                WHERE `idCard` IN
                (SELECT `idCard`
                        FROM `admin_application_info`
                        WHERE `id` IN (".$ids.")
                )
            ");

            AdminFunction::deleteEl($ids, 'admin_application_info', '/admin/apply/', $messG['Видалення пройшло успішно!']);
        }
    }

    // Filter
    if(isset($_GET['filterReset'])){
        header('Location: /admin/apply/');
    }

    $application_info = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_application_info",
        'url'        => "/admin/apply/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}