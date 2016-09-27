<?php
if(isset($_REQUEST['edit'])){
    if(isset($_POST['ok'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['last_name'] = (empty($_POST['last_name'])? 'class="error"' : '');
        $check['first_name'] = (empty($_POST['first_name'])? 'class="error"' : '');
        $check['is_records_name'] = (strlen($_POST['is_records_name']) == 0 || !isset(ApplyCard::param(1, 'is_records_name')[$_POST['is_records_name']])? 'class="error"' : '');
        $check['gender'] = (strlen($_POST['gender']) == 0 || !isset(ApplyCard::param(1, 'gender')[$_POST['gender']])? 'class="error"' : '');
        $check['date_mm'] = (empty($_POST['date_mm']) || !in_array($_POST['date_mm'], ApplyCard::param(1, 'date_mm'))? 'class="error"' : '');
        $check['date_dd'] = (empty($_POST['date_dd']) || !in_array($_POST['date_dd'], ApplyCard::param(1, 'date_dd'))? 'class="error"' : '');
        $check['date_yyyy'] = (empty($_POST['date_yyyy']) || !in_array($_POST['date_yyyy'], ApplyCard::param(1, 'date_yyyy'))? 'class="error"' : '');
        $check['email'] = (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)? 'class="error"' : '');
        $check['about_us'] = (empty($_POST['about_us']) || !isset(ApplyCard::param(1, 'about_us')[$_POST['about_us']])? 'class="error"' : '');
        $check['country'] = (empty($_POST['country']) || !isset(ApplyCard::param(1, 'country')[$_POST['country']])? 'class="error"' : '');
        $check['services_IERF'] = (strlen($_POST['services_IERF']) == 0 || !isset(ApplyCard::param(1, 'services_IERF')[$_POST['services_IERF']])? 'class="error"' : '');
        $check['addressOneLine'] = (empty($_POST['addressOneLine'])? 'class="error"' : '');
        $check['addressTwoLine'] = (empty($_POST['addressTwoLine'])? 'class="error"' : '');
        $check['city'] = (empty($_POST['city'])? 'class="error"' : '');

        $email = q("
                SELECT `id`
                FROM `admin_application_info`
                WHERE `email` = '".$_POST['email']."'
                AND `id` != '".$_REQUEST['edit']."'
                LIMIT 1
        ");

        if($email->num_rows > 0){
            $check['email'] = 'class="error"';
        }

        if($_POST['is_records_name'] == 1){
            $check['last_name_records'] = (empty($_POST['last_name_records'])? 'class="error"' : '');
            $check['first_name_records'] = (empty($_POST['first_name_records'])? 'class="error"' : '');
        } else {
            $_POST['last_name_records'] = '';
            $_POST['first_name_records'] = '';
            $_POST['middle_name_records'] = '';
        }

        if(preg_match('#^(\+\d{1})-(\d{3})-(\d{3})-(\d{4})$#uis', $_POST['phone'], $matches)){
            $_POST['phone'] = $matches[1].'-'.$matches[2].'-'.$matches[3].'-'.$matches[4];
        } else {
            $check['phone'] = 'class="error"';
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
            $check['state'] = (strlen($_POST['state']) == 0 || !isset(ApplyCard::param(1, 'state')[$_POST['state']])? 'class="error"' : '');
            $check['zip_code'] = (empty($_POST['zip_code'])? 'class="error"' : '');

            $_POST['region'] = '';
            $_POST['postal_code'] = '';
        }

        $glob3 = ApplyCard::param(3, 'globPost');

        foreach($glob3 as $v){
            if($v == 'admission_ap_pur' || $v == 'admission_to'){
                if(!isset($_POST[$v])){
                    $_POST[$v] = array();
                } else {
                    continue;
                }
            }
        }

        $check['main_purpose'] = (empty($_POST['main_purpose']) || !array_key_exists($_POST['main_purpose'], ApplyCard::param(3, 'main_purpose'))? 'class="error"' : '');

        if($_POST['main_purpose'] == 1){
            $check['admission_to'] = (count($_POST['admission_to']) <= 0 || arrayNotKey($_POST['admission_to'], ApplyCard::param(3, 'admission_to'))? 'class="error"' : '');
        } elseif($_POST['main_purpose'] == 4) {
            $check['please_spec'] = (empty($_POST['please_spec'])? 'class="error"' : '');
        }

        $check['admission_ap_pur'] = (count($_POST['admission_ap_pur']) > 0 && arrayNotKey($_POST['admission_ap_pur'], ApplyCard::param(3, 'admission_ap_pur'))? 'class="error"' : '');

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

        $check['document_requirements'] = (strlen($_POST['document_requirements']) == 0 || !isset(ApplyCard::param(3, 'document_requirements')[$_POST['document_requirements']])? 'class="error"' : '');

        $check['report_type'] = (count($_POST['report_type']) <= 0 || arrayNotKey($_POST['report_type'], ApplyCard::param(3, 'report_type'))? 'class="error"' : '');

        $check['applicant_copy'] = (empty($_POST['applicant_copy']) || !isset(ApplyCard::param(4, 'applicant_copy')[$_POST['applicant_copy']])? 'class="error"' : '');

        $check['ap_institution'] = (empty($_POST['ap_institution'])? 'class="error"' : '');
        $check['ap_attention_to'] = (empty($_POST['ap_attention_to'])? 'class="error"' : '');
        $check['ap_department'] = (empty($_POST['ap_department'])? 'class="error"' : '');
        $check['ap_address1'] = (empty($_POST['ap_address1'])? 'class="error"' : '');
        $check['ap_address2'] = (empty($_POST['ap_address2'])? 'class="error"' : '');
        $check['ap_city'] = (empty($_POST['ap_city'])? 'class="error"' : '');
        $check['ap_liability'] = (!isset($_POST['ap_liability']) || empty($_POST['ap_liability'])? 'class="error"' : '');
        $check['ap_mailing_us'] = (strlen($_POST['ap_mailing_us']) == 0 || !isset(ApplyCard::param(4, 'ap_mailing_us')[$_POST['ap_mailing_us']])? 'class="error"' : '');
        $check['ap_mailing_all'] = (strlen($_POST['ap_mailing_all']) == 0 || !isset(ApplyCard::param(4, 'ap_mailing_all')[$_POST['ap_mailing_all']])? 'class="error"' : '');

        if(!preg_match('#^(\d{3})-(\d{3})-(\d{4})$#uis', $_POST['ap_phone'], $matches)){
            $check['ap_phone'] = 'class="error"';
        }

        if($_POST['applicant_copy'] == 2){
            $check['ap_region'] = (empty($_POST['ap_region'])? 'class="error"' : '');
            $check['ap_postal_code'] = (empty($_POST['ap_postal_code'])? 'class="error"' : '');
            $check['ap_country'] = (empty($_POST['ap_country']) || !isset(ApplyCard::param(4, 'ap_country')[$_POST['ap_country']])? 'class="error"' : '');

            $_POST['ap_state'] = '';
            $_POST['ap_zip_code'] = '';
        } elseif($_POST['applicant_copy'] == 1) {
            $check['ap_state'] = (strlen($_POST['ap_state']) == 0 || !isset(ApplyCard::param(4, 'ap_state')[$_POST['ap_state']])? 'class="error"' : '');
            $check['ap_zip_code'] = (empty($_POST['ap_zip_code'])? 'class="error"' : '');

            $_POST['ap_region'] = '';
            $_POST['ap_postal_code'] = '';
        }

        $check['turnaround_time'] = (strlen($_POST['turnaround_time']) <= 0 || !isset(ApplyCard::param(5, 'turnaround_time')[$_POST['turnaround_time']])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            $_POST['active'] = !isset($_POST['active'])? 0 : (int)$_POST['active'];
            $_POST['admission_ap_pur'] = trim(implode(',', $_POST['admission_ap_pur']), ',');
            $_POST['admission_to'] = trim(implode(',', $_POST['admission_to']), ',');
            $country = ($_POST['applicant_copy'] == 1? 'USA' : $_POST['ap_country']);
            $ap_mailing = ($_POST['applicant_copy'] == 1? $_POST['ap_mailing_us'] : $_POST['ap_mailing_all']);

            q("
               UPDATE `admin_application_info` SET
                `active`              = ".$_POST['active'].",
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
                `services_IERF`       = '".$_POST['services_IERF']."',
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
                WHERE `id` = '".$_REQUEST['edit']."'
            ");

            sessionInfo('/admin/cab/', $messG['Редагування пройшло успішно!'], 1);
        }
    }

    for($i = 1; $i <= 6; ++$i){
        if($i == 2){
            continue;
        }

        $param[$i] = ApplyCard::param($i);
    }

    $arResult = q("
        SELECT *
        FROM `admin_application_info`
        WHERE `id` = ".(int)$_REQUEST['edit']."
    ");

    if($arResult->num_rows == 0){
        sessionInfo('/admin/cab/', $messG['Eлемент з таким ID неіснує!']);
    } else {
        if(!isset($_POST) || count($_POST) <= 0){
            foreach(hsc($arResult->fetch_assoc()) as $k => $v){
                if($k == 'admission_to' || $k == 'admission_ap_pur'){
                    $_POST[$k] = explode(',', $v);
                } elseif($k == 'report_type') {
                    $_POST[$k] = array($v);
                } else {
                    $_POST[$k] = $v;
                }
            }

            if($_POST['applicant_copy'] == 1){
                $_POST['ap_mailing_us'] = $_POST['ap_mailing'];
            } else {
                $_POST['ap_mailing_all'] = $_POST['ap_mailing'];
            }

            unset($_POST['ap_mailing']);
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
    }

    Core::$JS[] = "<script src=\"/skins/admin/js/apply.min.js\" defer></script>";
} else {
    if(isset($_REQUEST['ajax'], $_REQUEST['dynamicEditHtml'])){
        AdminFunction::dynamicEditHtml($_POST, 'admin_application_info', '/admin/cab/');
    } elseif(isset($_POST['arr']) && count($_POST['arr']) > 0) {
        AdminFunction::dynamicEditQuery($_POST['arr'], 'admin_application_info', '/admin/cab/', $messG['Редагування пройшло успішно!']);
    } elseif(isset($_REQUEST['delete']) || isset($_POST['delete'])) { // Delete
        $ids = (isset($_POST['ids'])? implode(',', $_POST['ids']) : $_REQUEST['delete']);
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

            AdminFunction::deleteEl($ids, 'admin_application_info', '/admin/cab/', $messG['Видалення пройшло успішно!']);
        }
    } elseif(isset($_POST['deactivate']) && isset($_POST['ids'])) { // Deactivate
        AdminFunction::deactivateEl(implode(',', $_POST['ids']), 'admin_application_info', '/admin/cab/', $messG['Деактивація пройшла успішно!']);
    } elseif(isset($_POST['activate']) && isset($_POST['ids'])) { // Activate
        AdminFunction::activeEl(implode(',', $_POST['ids']), 'admin_application_info', '/admin/cab/', $messG['Активація пройшла успішно!']);
    }

    // Filter
    if(isset($_REQUEST['filterReset'])){
        header('Location: /admin/cab/');
    }

    $application_info = AdminFunction::StructureMenu(array(
        'db_table'   => "admin_application_info",
        'url'        => "/admin/cab/",
        'numPage'    => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
        'pagination' => array(
            'count_show' => 5,
            'css_class'  => "pagination-admin",
        ),
        'filter'     => (!isset($_GET['filter'])? false : true),
    ));
}