<?php
if(isset($_POST['ok'], $_POST['number'], $_POST['date'], $_POST['email'])){
    $error = array();
    $_POST = trimAll($_POST);

    $check['number'] = (empty($_POST['number'])? 'class="error"' : '');
    $check['email'] = (empty($_POST['email'])? 'class="error"' : '');
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
            AND `email`     = '".$_POST['email']."'
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
            header("Location: /apply/review/");
            exit();
        } else {
            sessionInfo('/apply/', '<p>WCES ID does not exist!</p>');
        }
    }
}

if(isset($_GET['cron']) && $_GET['cron'] == 'ok' && $_SERVER['REMOTE_ADDR'] == Core::$SERVER_IP){
    $getID = q("
        SELECT `id`, `idCard`, `email`
        FROM `admin_application_info`
        WHERE 
        (`active` = 0 AND `date_create` <= NOW() - INTERVAL 7 DAY) or (`payment_ok` = 1 AND `active` = 0 AND `date_create` <= NOW() - INTERVAL 9 DAY)
    ");

    if($getID->num_rows > 0){
        while($ar = hsc($getID->fetch_assoc())){
            $id[] = $ar['id'];
            $email[] = $ar['email'];
            $idCard[] = $ar['idCard'];
        }

        $id = implode($id, ',');
        $email = implode($email, ',');
        $idCard = implode($idCard, ',');

        $history = q("
            SELECT `fileScan`
            FROM `admin_educational_history`
            WHERE `idCard` IN (".$idCard.")
        ");

        if($history->num_rows > 0){
            while($file = $history->fetch_assoc()){
                foreach(explode('#|#', $file['fileScan']) as $k => $v){
                    if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                        unlink($_SERVER['DOCUMENT_ROOT'].$v);
                    }
                }
            }
        }

        q("
            DELETE FROM `admin_educational_history`
            WHERE `idCard` IN (".$idCard.")
        ");

        q("
            DELETE FROM `admin_official_agency_copy`
            WHERE `idCard` IN (".$idCard.")
        ");

        q("
            DELETE FROM `steps_ok_cards`
            WHERE `idCard` IN (".$idCard.")
        ");
    }
}