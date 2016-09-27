<?php
if(isset($_POST['ok'], $_POST['turnaround_time'], $_POST['update'])){
    $error = array();
    $_POST = trimAll($_POST);

    if(!$data = ApplyCard::checkData()){
        sessionInfo('/cab/apply-user/', '<p>час зберігання даних вийшов, увійдіть знов у свій кабінет і заповніть дані!</p>');
    } else {
        $globPost = ApplyCard::param(5, 'globPost');
    }

    $check['turnaround_time'] = (strlen($_POST['turnaround_time']) <= 0 || !isset(ApplyCard::param(5, 'turnaround_time')[$_POST['turnaround_time']])? 'class="error"' : '');

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
                UPDATE `admin_application_info` SET
                `turnaround_time`  = '".$_POST['turnaround_time']."',
                `agent`            = '".mres($_SERVER['HTTP_USER_AGENT'])."',
                `user_ip`          = '".mres($_SERVER['REMOTE_ADDR'])."',
                `date_custom`      = NOW()
                WHERE `id` = '".(int)$el['id']."'
            ");

            setcookie('idCardHash', $el['idCardHash'], time() + 3600, '/');
            header('Location: '.(isset($_REQUEST['review'])? '/cab/review/' : '/cab/review/').'');
            exit();
        } else {
            sessionInfo('/cab/review/', '<p>Такого ід не існує!</p>', 0, 0);
        }
    }
}

if($data = ApplyCard::checkData()){
    $globPost = ApplyCard::param(5, 'globPost');
    $param = ApplyCard::param(5);

    foreach($data as $k => $v){
        if(in_array($k, $globPost) && !isset($_POST[$k])){
            $_POST[$k] = $v;
        }
    }

    $_POST['update'] = $data['id'];
} else {
    sessionInfo('/cab/apply-user/', '<p>Щоб перейти у цей розділ розпочніть нову анкету або продовжіть існуючу, або час очікування закінчився.</p>');
}