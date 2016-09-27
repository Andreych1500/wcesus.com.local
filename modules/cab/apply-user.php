<?php
if(isset($_POST['ok'], $_POST['number'], $_POST['date'])){
    $error = array();
    $_POST = trimAll($_POST);

    $check['number'] = (empty($_POST['number'])? 'class="error"' : '');
    $check['date'] = (empty($_POST['date']) || !preg_match("#(\d{2})-(\d{2})-(\d{4})#uis", $_POST['date'], $matches)? 'class="error"' : '');

    if(in_array('class="error"', $check)){
        $error['stop'] = 1;
    }

    if(!count($error)){
        $_POST = mres($_POST);

        $select = q("
            SELECT `id`, `idCardHash`
            FROM `admin_application_info`
            WHERE `idCard`  = '".$_POST['number']."'
            AND `date_mm`   = '".mres($matches[1])."'
            AND `date_dd`   = '".mres($matches[2])."'
            AND `date_yyyy` = '".mres($matches[3])."'
            LIMIT 1
        ");

        if($select->num_rows > 0){
            $res = hsc($select->fetch_assoc());

            q("
                UPDATE `admin_application_info` SET
                `agent`   = '".mres($_SERVER['HTTP_USER_AGENT'])."',
                `user_ip` = '".mres($_SERVER['REMOTE_ADDR'])."'
                WHERE `id` = '".mres($res['id'])."'
                AND `idCardHash` = '".mres($res['idCardHash'])."'
            ");

            setcookie('idCardHash', $res['idCardHash'], time() + 3600, '/');
            sessionInfo('/cab/application-info/', '', 1);
        } else {
            sessionInfo('/cab/apply-user/', '<p>Такої карточки не існує</p>');
        }
    }
}