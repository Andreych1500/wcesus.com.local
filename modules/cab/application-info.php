<?php
if(isset($_POST['ok'])){
    $error = array();
    $_POST = trimAll($_POST);
    $globPost = ApplyCard::param(1, 'globPost');

    foreach($globPost as $v){
        if(!array_key_exists($v, $_POST)){
            $check['POST'] = 'class="error"';
            break;
        }
    }

    if(isset($check['POST'])){
        $error['stop'] = 1;
    } else {
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
                sessionInfo('/cab/application-info/', '<p>Емейл вже занятий!</p>', 0, 0);
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
                        `services_IERF`       = '".$_POST['services_IERF']."',
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
                    header('Location: '.(isset($_REQUEST['review'])? '/cab/review/' : '/cab/education-history/').'');
                    exit();
                } else {
                    sessionInfo('/cab/application-info/', '<p>Такого ід не існує!</p>', 0, 0);
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
                sessionInfo('/cab/application-info/', '<p>Емейл вже занятий!</p>', 0, 0);
            } else {
                $newNumCard = ApplyCard::createCard();

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
                    `services_IERF`       = '".$_POST['services_IERF']."',
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
                    'number'    => $newNumCard
                );

                Mail::$text = TemplateMail::HtmlMail($set, 'create_new_card', $arMainParam);

                if(Mail::$text){
                    Mail::$to = $_POST['email'];
                    Mail::send();
                }

                setcookie('idCardHash', ApplyCard::hash($newNumCard.$_POST['email']), time() + 3600, '/');
                header('Location: /cab/education-history/');
                exit();
            }
        }
    }
}

if(isset($_REQUEST['newCard'])){
    if(isset($_COOKIE['idCardHash'])){
        setcookie('idCardHash', '', time() - 3600, '/');
    }

    header('Location: /cab/application-info/');
    exit();
}

$param = ApplyCard::param(1);

if($data = ApplyCard::checkData()){
    $globPost = ApplyCard::param(1, 'globPost');

    foreach($data as $k => $v){
        if(in_array($k, $globPost) && !isset($_POST[$k])){
            $_POST[$k] = $v;
        }
    }

    $_POST['update'] = $data['id'];
}

Core::$JS[] = "<script src=\"/skins/default/js/application-info.min.js\" defer></script>";