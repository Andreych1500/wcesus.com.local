<?php
$keyPost = ApplyCard::param(1, array('keyPost'));
$param = array_merge(ApplyCard::param(1), ApplyCard::param('glob', array(
    'country',
    'date_yyyy',
    'date_mm',
    'date_dd',
    'state'
)));

if(isset($_POST['ok'])){
    $error = array();
    $_POST = trimAll($_POST);

    foreach($keyPost['keyPost'] as $v){
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

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }
    }

    if(!count($error)){
        $_POST = mres($_POST);

        if(isset($_POST['update'])){
            $email = q("
                 SELECT `id`
                 FROM `admin_application_info`
                 WHERE `email` = '".$_POST['email']."'
                 AND `id` != '".$_POST['update']."'
                 LIMIT 1
            ");

            if($email->num_rows > 0){
                $check['email'] = 'class="error"';
                sessionInfo('/apply/application-info/', '<p>The selected Email address is already existing!</p>', 0, 0);
            } else {
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
                         `agent`               = '".mres($_SERVER['HTTP_USER_AGENT'])."',
                         `user_ip`             = '".mres($_SERVER['REMOTE_ADDR'])."',
                         `date_custom`         = NOW()
                         WHERE `id` = '".(int)$el['id']."'
                    ");

                    setcookie('idCardHash', $el['idCardHash'], time() + 3600, '/');
                    header('Location: '.(isset($_GET['review'])? '/apply/review/' : '/apply/education-history/').'');
                    exit();
                } else {
                    sessionInfo('/apply/application-info/', '<p>WCES ID does not exist!</p>', 0, 0);
                }
            }
        } else {
            $email = q("
                 SELECT `id`
                 FROM `admin_application_info`
                 WHERE `email` = '".$_POST['email']."'
                 LIMIT 1
             ");

            if($email->num_rows > 0){
                $check['email'] = 'class="error"';
                sessionInfo('/apply/application-info/', '<p>The selected Email address is already existing!</p>', 0, 0);
            } else {
                $newNumCard = ApplyCard::createCard();

                q("
                    INSERT INTO `steps_ok_cards` SET
                    `idCard`  = '".mres($newNumCard)."',
                    `step1`   = 1
                ");

                q("
                    INSERT INTO `admin_application_info` SET
                    `idCard`              = '".mres($newNumCard)."',
                    `idCardHash`          = '".mres(ApplyCard::hash($newNumCard.$_POST['email']))."',
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
                    `agent`               = '".mres($_SERVER['HTTP_USER_AGENT'])."',
                    `user_ip`             = '".mres($_SERVER['REMOTE_ADDR'])."',
                    `date_create`         = NOW(),
                    `date_custom`         = NOW()
                ");

                $set = array(
                    'number' => $newNumCard,
                    'email'  => $_POST['email'],
                    'date_birth_day' => $_POST['date_mm'].'-'.$_POST['date_dd'].'-'.$_POST['date_yyyy']
                );

                Mail::$text = TemplateMail::HtmlMail($set, 'create_new_card', $arMainParam);

                if(Mail::$text){
                    Mail::$to = $_POST['email'];
                    Mail::send();
                }

                setcookie('idCardHash', ApplyCard::hash($newNumCard.$_POST['email']), time() + 3600, '/');
                header('Location: /apply/education-history/');
                exit();
            }
        }
    }
}

if(isset($_GET['newCard'])){
    if(isset($_COOKIE['idCardHash'])){
        setcookie('idCardHash', '', time() - 3600, '/');
    }

    header('Location: /apply/application-info/');
    exit();
}

if($data = ApplyCard::checkData()){
    foreach($data as $k => $v){
        if(in_array($k, $keyPost['keyPost']) && !isset($_POST[$k])){
            $_POST[$k] = $v;
        }
    }

    $_POST['update'] = $data['id'];
}

Core::$JS[] = "<script src=\"/skins/default/js/application-info.min.js\" defer></script>";