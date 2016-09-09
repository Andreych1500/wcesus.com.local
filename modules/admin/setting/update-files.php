<?php
if(isset($_REQUEST['reload'])){

    q(" UPDATE `admin_site_cache` SET
        `number_cache`  = `number_cache` + 1,
        `new_resource`  = ".date_timestamp_get(date_create()).",
        `user_custom`   = '".mres($_SESSION['user']['last_name'].' '.$_SESSION['user']['name'])."'
         WHERE `id` = 1
    ");

    sessionInfo('/admin/setting/update-files/', $mess['Кеш файлів успішно поновлений!'], 1);
}

$arResult = q("
    SELECT *
    FROM `admin_site_cache`
    WHERE `id` = 1
")->fetch_assoc();