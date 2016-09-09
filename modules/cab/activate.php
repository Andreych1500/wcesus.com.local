<?php
if(isset($_GET['id'], $_GET['hash'])){
    $user = q("
        SELECT *
        FROM `admin_users_list`
        WHERE `id` = ".(int)$_GET['id']."
        AND `hash` = '".mres($_GET['hash'])."' 
        AND `access` != 2
        LIMIT 1
    ");

    if($user->num_rows){
        $active = (isset($_GET['active'])? '`active` = 1,' : '');

        q(" UPDATE `admin_users_list` SET
    		    ".$active."
    		    `access` = 1
    		    WHERE `id` = ".(int)$_GET['id']."
    		    AND `hash` = '".mres($_GET['hash'])."'
      	");
        
        sessionInfo('/cab/activate/', 'Активація пройшла успішно!');
    } else {
        sessionInfo('/cab/activate/', 'Ви пройшли по неправельній силці!');
    }
} else {
    if(isset($_SESSION['info']['text'])){
        $last_info = $_SESSION['info']['text'];
        unset($_SESSION['info']);
    } else {
        header('Location: /');
        exit();
    }
}