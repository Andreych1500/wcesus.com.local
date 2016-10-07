<?php
if($accessCab){
    if(isset($_POST['replace_password'], $_POST['check_password'], $_POST['new_password'], $_POST['your_password'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['check_password'] = (empty($_POST['check_password']) || $_POST['check_password'] != $_POST['new_password']? 'class="error"' : '');
        $check['new_password'] = (empty($_POST['new_password']) || strlen($_POST['new_password']) < 6? 'class="error"' : '');
        $check['your_password'] = (empty($_POST['your_password'])? 'class="error"' : '');

        if(in_array('class="error"', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            $checkPass = q("
                SELECT `id`, `password`
                FROM `admin_application_info`
                WHERE `password` = '".myHash($_POST['your_password'])."'
                AND `id` = ".mres($_SESSION['dataCard']['id'])."
                LIMIT 1
            ");

            if($checkPass->num_rows > 0){
                q("
                    UPDATE `admin_application_info` SET
                    `password` = '".myHash($_POST['new_password'])."'
                    WHERE `id` = ".mres($_SESSION['dataCard']['id'])."
                    LIMIT 1
                ");

                sessionInfo('/cab/', '<p>Ваш пароль успішно змінено, зберігайте його ретельно та ніде не розповсюджуйте!</p>', 1);
            } else {
                $check['your_password'] = 'class="error"';
            }
        }
    }

    $param = ApplyCard::param('glob');

    for($i = 1; $i < 7; ++$i){
        if($i == 2){
            continue;
        }
        $param = array_merge($param, ApplyCard::param($i));
    }

    if(isset($_GET['payment']) && !empty($_GET['payment'])){
        $getEl = q("
            SELECT *
            FROM `admin_cab_copy_info`
            WHERE `id` = '".mres($_GET['payment'])."'
            AND `idCard` = '".mres($_SESSION['dataCard']['idCard'])."'
            AND `payment_status` = 0
            LIMIT 1
        ");

        if($getEl->num_rows > 0){
            require_once($_SERVER['DOCUMENT_ROOT'].'/libs/PayPal/class_PayPal.php'); // Підключаємо класс PayPal

            $p = new class_PayPal;                                                   // Створюєм екземпляр класа
            $p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';        // Тестовий url PayPal
            //$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';              // Робочий url PayPal для оплат

            $this_script = $arMainParam['url_http_site'].'/cab/main/';                 // Сторінка cancel, success, ipn!!!

            $arPayment = hsc($getEl->fetch_assoc());
            $priNum = $arPayment['id'].' - '.$arPayment['idCard'];

            $price = ($arPayment['price'] == '0.00'? '0.01' : $arPayment['price']);

            // Якщо потрібно додаткові параметри додаємо тут!
            $p->add_field('item_name', 'Service in cab copy');  // Короткий опис для покупця
            $p->add_field('amount', $price);       // Повна ціна оплати
            $p->add_field('item_number', $priNum);              // Номер замовлення ( Унікальний!!! )
            $p->add_field('no_shipping', '1');                  // Запрос на адрес доставки (виключили)
            $p->add_field('currency_code', 'USD');              // Валюта
            $p->add_field('charset', 'utf-8');                  // Юнікод

            $p->add_field('business', 'Savitskuy-facilitator@ukr.net'); // Email PayPal продавця

            $p->add_field('return', $this_script.'payment-success/');
            $p->add_field('cancel_return', $this_script.'payment-cancel/');
            $p->add_field('notify_url', $this_script.'ipn-access/');

            $p->submit_paypal_post(); // Формумання скритої форми з параметрами які ми вказали
            //$p->dump_fields();      // Вивід на екран даних для перевірки полів
        } else {
            header('Location: /cab/');
            exit();
        }
    }

    if(isset($_GET['key1']) && $_GET['key1'] == 'payment-cancel'){
        sessionInfo('/cab/', '<p>The payment was not complete. You canceled your payment!</p>');
    }

    if(isset($_GET['key1']) && $_GET['key1'] == 'payment-success'){
        sessionInfo('/cab/', '<p>The payment is successful. We will check your payment data, and after verifying it, ваш статус ціїє анкети буде опчаний і ми відішлемо вам копії.</p>', 1);
    }

    if(isset($_POST['add_copy'], $_POST['text_copy'], $_POST['mailing_copy'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['text_copy'] = (empty($_POST['text_copy'])? 'error' : '');
        $check['mailing_copy'] = (empty($_POST['mailing_copy']) || !isset($param['mailing_copy'][$_POST['mailing_copy']])? 'class="error"' : '');

        if(in_array('class="error"', $check) || in_array('error', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            $all_card = q("
                SELECT `id`, `idCard`
                FROM `admin_cab_copy_info`
                WHERE `idCard` = '".mres($_SESSION['dataCard']['idCard'])."'
            ");

            if($all_card->num_rows >= 10){
                sessionInfo('/cab/', '<p>Існує ліміт у 10 копій</p>');
            }

            if(isset($_GET['edit'])){

                $card = q("
                    SELECT `id`, `idCard`
                    FROM `admin_cab_copy_info`
                    WHERE `id` = '".(int)$_GET['edit']."'
                    AND `idCard` = '".mres($_SESSION['dataCard']['idCard'])."'
                    LIMIT 1
                ");

                if($card->num_rows > 0){
                    $price = $param['mailing_copy'][$_POST['mailing_copy']]['price'].'.00';

                    q("
                        UPDATE `admin_cab_copy_info` SET
                        `text_copy`    = '".$_POST['text_copy']."',
                        `mailing_copy` = '".$_POST['mailing_copy']."',
                        `price`          = '".$price."'
                        WHERE `id`   = '".mres($_GET['edit'])."'
                        AND `idCard` = '".mres($_SESSION['dataCard']['idCard'])."'
                    ");

                    sessionInfo('/cab/', '<p>Редагування успішно проведено!</p>', 1);
                } else {
                    sessionInfo('/cab/', '<p>Цей ідентифікатор скопії не є дійсний для твого кабінету!</p>');
                }
            } else {
                $price = $param['mailing_copy'][$_POST['mailing_copy']]['price'].'.00';

                q("
                    INSERT INTO `admin_cab_copy_info` SET
                    `idCard`         = '".mres($_SESSION['dataCard']['idCard'])."',
                    `text_copy`      = '".$_POST['text_copy']."',
                    `mailing_copy`   = '".$_POST['mailing_copy']."',
                    `price`          = '".$price."',
                    `date_create`    = NOW()
                ");

                sessionInfo('/cab/', '<p>Новий запис успішно добавлено!</p>', 1);
            }
        }
    }

    $new_copy = q("
        SELECT * 
        FROM `admin_cab_copy_info`
        WHERE `idCard` = '".mres($_SESSION['dataCard']['idCard'])."'
    ");

    if(isset($_GET['edit'])){
        $oacEd = q("
            SELECT *
            FROM `admin_cab_copy_info`
            WHERE `idCard` = '".mres($_SESSION['dataCard']['idCard'])."'
            AND `id` = '".mres($_GET['edit'])."'
            LIMIT 1
        ");

        if($oacEd->num_rows > 0){
            foreach(hsc($oacEd->fetch_assoc()) as $k => $v){
                $_POST[$k] = $v;
            }
        } else {
            sessionInfo('/cab/', '<p>There is no such paper copies of your application!</p>');
        }
    }

    if(isset($_GET['remove'])){
        q("
            DELETE FROM `admin_cab_copy_info`
            WHERE `id` = ".(int)$_GET['remove']."
            AND `idCard` = '".mres($_SESSION['dataCard']['idCard'])."'
        ");

        header('Location: /cab/');
        exit();
    }

    /* anket */
    $data = hsc(q("
        SELECT *
        FROM `admin_application_info`
        WHERE `id` = ".(int)$_SESSION['dataCard']['id']."
        AND `idCard` = '".mres($_SESSION['dataCard']['idCard'])."'
        LIMIT 1
    ")->fetch_assoc());

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
    /* end anket */

    Core::$JS[] = "<script src=\"/skins/default/js/profile.min.js\" defer></script>";
} else {
    if(isset($_POST['log_in'], $_POST['email'], $_POST['password'])){
        $error = array();
        $_POST = trimAll($_POST);

        $check['password'] = (empty($_POST['password']) || strlen($_POST['password'] > 32)? 'error' : '');
        $check['email'] = (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)? 'class="error"' : '');

        if(in_array('class="error"', $check) || in_array('error', $check)){
            $error['stop'] = 1;
        }

        if(!count($error)){
            $_POST = mres($_POST);

            $select = q("
                SELECT `id`, `idCard`, `email`, `first_name`, `last_name`
                FROM `admin_application_info`
                WHERE `email`   = '".$_POST['email']."'
                AND `password`  = '".myHash($_POST['password'])."'
                AND `active` = 1
                AND `access` = 1
                LIMIT 1
            ");

            if($select->num_rows > 0){
                $_SESSION['dataCard'] = $select->fetch_assoc();

                if(isset($_POST['save'])){

                    q("
                        UPDATE `admin_application_info` SET
                        `idCardHash` = '".ApplyCard::hash($_SESSION['dataCard']['idCard'].$_SESSION['dataCard']['email'])."',
                        `user_ip` = '".mres($_SERVER['REMOTE_ADDR'])."',
                        `agent` = '".mres($_SERVER['HTTP_USER_AGENT'])."'
                        WHERE `email`  = '".mres($_POST['email'])."'
                        AND `password`   = '".myHash($_POST['password'])."'
                        LIMIT 1
                    ");

                    setcookie('dataCard', ApplyCard::hash($_SESSION['dataCard']['idCard'].$_SESSION['dataCard']['email']), time() + 3600, '/');
                    setcookie('id-idCard', $_SESSION['dataCard']['id'], time() + 3600, '/');
                }

                header("Location: /cab/");
                exit();
            } else {
                $check['email'] = "class=\"error\"";
                $check['password'] = "error";
            }
        }
    }

    if(isset($_GET['key1']) == 'ipn-access'){
        // IP PayPal '173.0.82.126 -> test' '173.0.81.1 and 173.0.81.33' -> machine){

        $ipPayPal = array(
            '173.0.82.126'
            //'173.0.81.33',
            //'173.0.81.1'
        );

        if(in_array($_SERVER['REMOTE_ADDR'], $ipPayPal)){
            require_once($_SERVER['DOCUMENT_ROOT'].'/libs/PayPal/class_PayPal.php'); // Підключаємо класс PayPal

            $p = new class_PayPal;                                                   // Створюєм екземпляр класа
            $p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';        // Тестовий url PayPal
            //$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';              // Робочий url PayPal для оплат

            $p->ipn_log_file = $_SERVER['DOCUMENT_ROOT'].'/libs/PatPal/ipn_cab_result.log';

            if($p->validate_ipn()){
                // Тут перевіряємо дані які зберігаються у ipn_data() array.
                $inpResult = explode(' - ', $p->ipn_data['item_number']);

                $getCardActive = q("
                    SELECT *
                    FROM `admin_cab_copy_info`
                    WHERE `id` = '".mres($inpResult[0])."'
                    AND `idCard` = '".mres($inpResult[1])."'
                    LIMIT 1
                ");

                if($getCardActive->num_rows > 0){
                    $query = "`payment_status` = 1";
                } else {
                    $query = "`payment_status` = 0";
                }

                q("
                    UPDATE `admin_cab_copy_info` SET
                    ".$query."
                    WHERE `id` = '".mres($inpResult[0])."'
                    AND `idCard` = '".mres($inpResult[1])."'
                    LIMIT 1
               ");
            }
        }
    }
}