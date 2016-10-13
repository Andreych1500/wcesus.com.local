<?php
$keyPost = ApplyCard::param(5, array('keyPost'));
$param = ApplyCard::param(5);

if(isset($_POST['ok'], $_POST['update'])){
    $error = array();
    $_POST = trimAll($_POST);

    if(!$data = ApplyCard::checkData()){
        sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
    }

    $check['turnaround_time'] = (!isset($_POST['turnaround_time']) || empty($_POST['turnaround_time']) || !isset($param['turnaround_time'][$_POST['turnaround_time']])? 'class="error"' : '');

    if(in_array('class="error"', $check)){
        $error['stop'] = 1;
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

            q("
                UPDATE `steps_ok_cards` SET
                `step5`   = 1
                WHERE `idCard` = '".mres($data['idCard'])."'
            ");

            q("
                UPDATE `admin_application_info` SET
                `turnaround_time`  = '".$_POST['turnaround_time']."',
                `agent`            = '".mres($_SERVER['HTTP_USER_AGENT'])."',
                `user_ip`          = '".mres($_SERVER['REMOTE_ADDR'])."',
                `date_custom`      = NOW()
                WHERE `id` = '".(int)$el['id']."'
            ");

            ApplyCard::priceCard($data['idCard'], true); // Update peirce

            setcookie('idCardHash', $el['idCardHash'], time() + 3600, '/');
            header('Location: '.(isset($_REQUEST['review'])? '/apply/review/' : '/apply/review/').'');
            exit();
        } else {
            sessionInfo('/apply/review/', '<p>Wrong WCES ID, access denied!</p>', 0, 0);
        }
    }
}

if($data = ApplyCard::checkData()){
    foreach($data as $k => $v){
        if(in_array($k, $keyPost['keyPost']) && !isset($_POST[$k])){
            $_POST[$k] = $v;
        }
    }

    $_POST['update'] = $data['id'];
} else {
    sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
}