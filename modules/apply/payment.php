<?php
if(isset($_POST['ok'])){ // Процес оплати...
    if(!$data = ApplyCard::checkData()){
        sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
    } else {
        $checkStep = q("
            SELECT *
            FROM `steps_ok_cards`
            WHERE `idCard` = '".mres($data['idCard'])."'
            AND `step1` = 1
            AND `step2` = 1
            AND `step3` = 1
            AND `step4` = 1
            AND `step5` = 1
            LIMIT 1
        ");

        if($checkStep->num_rows == 0){
            sessionInfo('/apply/review/', '<p>Complete all fields in the application and come back to the payment stage!</p>');
        }
    }

    require_once($_SERVER['DOCUMENT_ROOT'].'/libs/PayPal/class_PayPal.php'); // Підключаємо класс PayPal

    $p = new class_PayPal;                                                   // Створюєм екземпляр класа
    $p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';        // Тестовий url PayPal
    //$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';              // Робочий url PayPal для оплат

    $this_script = $arMainParam['url_http_site'].'/apply/payment/';                 // Сторінка cancel, success, ipn!!!

    if(!isset($_POST['price']) || !preg_match('#^\d+\.00$#uis', $_POST['price'])){
        sessionInfo('/apply/payment/', '<p>Please do not change the amount of the code to pay!</p>');
    } else {
        // Якщо потрібно додаткові параметри додаємо тут!
        $p->add_field('first_name', $data['first_name']);
        $p->add_field('last_name', $data['last_name']);
        $p->add_field('item_name', 'Service Online');      // Короткий опис для покупця
        $p->add_field('amount', $_POST['price']);          // Повна ціна оплати
        $p->add_field('item_number', $data['idCardHash']); // Номер замовлення ( Унікальний!!! )
        $p->add_field('no_shipping', '1');                 // Запрос на адрес доставки (виключили)
        $p->add_field('currency_code', 'USD');             // Валюта
        $p->add_field('charset', 'utf-8');                 // Юнікод

        $p->add_field('business', 'Savitskuy-facilitator@ukr.net'); // Email PayPal продавця

        $p->add_field('return', $this_script.'payment-success/');
        $p->add_field('cancel_return', $this_script.'payment-cancel/');
        $p->add_field('notify_url', $this_script.'ipn-access/');

        $p->submit_paypal_post(); // Формумання скритої форми з параметрами які ми вказали
        //$p->dump_fields();      // Вивід на екран даних для перевірки полів
    }
}

if(isset($_GET['key1']) && $_GET['key1'] == 'payment-success'){
    if(isset($_POST) && count($_POST) > 0){
        setcookie('idCardHash', '', time() - 3600, '/');

        q("
            UPDATE `admin_application_info` SET
            `payment_ok` = 1
            WHERE `idCardHash` = '".mres($_POST['item_number'])."'
            AND `all_price` = '".mres($_POST['payment_gross'])."'
            AND `agent`   = '".mres($_SERVER['HTTP_USER_AGENT'])."'
            AND `user_ip` = '".mres($_SERVER['REMOTE_ADDR'])."'
            LIMIT 1 
        ");

        sessionInfo('/apply/', '<p>The payment is successful. We will check your payment data, and after verifying it, you will receive the password to your personal WCES account. At WCES account you will have access to your application, request additional copies, and track your application status.</p>', 1);
    } else {
        header('Location: /apply/payment/');
        exit();
    }
}

if(isset($_GET['key1']) && $_GET['key1'] == 'payment-cancel'){
    sessionInfo('/apply/payment/', '<p>The payment was not complete. You canceled your payment!</p>');
}

if(isset($_GET['key1']) == 'ipn-access'){

    // IP PayPal '173.0.82.126 -> test' '173.0.81.1 and 173.0.81.33' -> machine){
    //mail('Savitskuy@ukr.net', 'text', $_SERVER['REMOTE_ADDR']);
    //exit();
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

        if($p->validate_ipn()){
            // Тут перевіряємо дані які зберігаються у ipn_data() array.

            $getCardActive = q("
                SELECT *
                FROM `admin_application_info`
                WHERE `idCardHash` = '".mres($p->ipn_data['item_number'])."'
                AND `all_price` = '".mres($p->ipn_data['payment_gross'])."'
            ");

            if($getCardActive->num_rows > 0){
                $password = generationPass();
                $query = "`active` = 1, `access` = 1, `payment_ok` = 0, `password` = '".myHash($password)."'";

                $set = array(
                    'password' => $password
                );

                Mail::$text = TemplateMail::HtmlMail($set, 'payment_ok', $arMainParam);

                if(Mail::$text){
                    Mail::$to = mres($getCardActive->fetch_assoc()['email']);
                    Mail::send();
                }
            } else {
                $query = "`payment_ok` = 0";

                Mail::$text = TemplateMail::HtmlMail('', 'payment_no', $arMainParam);

                if(Mail::$text){
                    Mail::$to = mres($getCardActive->fetch_assoc()['email']);
                    Mail::send();
                }
            }

            q("
                UPDATE `admin_application_info` SET
                ".$query."
                WHERE `idCardHash` = '".mres($p->ipn_data['item_number'])."'
            ");
        }
    }
}

if($data = ApplyCard::checkData()){
    $checkStep = q("
        SELECT *
        FROM `steps_ok_cards`
        WHERE `idCard` = '".mres($data['idCard'])."'
        AND `step1` = 1
        AND `step2` = 1
        AND `step3` = 1
        AND `step4` = 1
        AND `step5` = 1
        LIMIT 1
    ");

    if($checkStep->num_rows == 0){
        sessionInfo('/apply/review/', '<p>Complete all fields in the application and come back to the payment stage!</p>');
    } else {
        $price = ApplyCard::getAllPrice($data);

        q("
             UPDATE `admin_application_info` SET
            `all_price` = ".mres($price.'.00')."
             WHERE `id` = ".mres($data['id'])."
             LIMIT 1
        ");

        $_POST['update'] = $data['id'];
    }
} else {
    sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
}