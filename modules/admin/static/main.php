<?php
if (!$globalAccess) {
    // Auth form
    if (isset($_POST['login'], $_POST['pass'])) {
        $error = array();

        $res = q("
            SELECT *
            FROM `admin_users_list`
            WHERE `login` = '".mres($_POST['login'])."'
            AND `pass`  = '".myHash($_POST['pass'])."'
            AND `access` = 5
            AND `active` != 0
            LIMIT 1  
        ");

        if ($res->num_rows) {
            $_SESSION['user'] = $res->fetch_assoc();
            $status = 'ok';

            if (isset($_POST['save'])) {
                q("
                    UPDATE `admin_users_list` SET
                    `hash` = '".myHash($_SESSION['user']['id'].$_SESSION['user']['login'].$_SESSION['user']['email'])."'
                    WHERE `login`  = '".mres($_POST['login'])."'
                    AND `pass`   = '".myHash($_POST['pass'])."'
                ");
                setcookie('authhash', myHash($_SESSION['user']['id'].$_SESSION['user']['login'].$_SESSION['user']['email']), time() + 636000, '/');
                setcookie('id', $_SESSION['user']['id'], time() + 636000, '/');
            }

            header("Location: /admin/");
            exit();
        } else {
            $error['notuser'] = 'error';
        }
    }
} else {
    $arResult = hsc(q("
	      SELECT *
	      FROM `admin_personal_interface`
	      WHERE `id` = 1
	  ")->fetch_assoc());
}