<?php
// Backup project
if(isset($_REQUEST['backup'])){

    $setting = q("
        SELECT *
        FROM `admin_backup_setting`
    ")->fetch_assoc();

    $return = BackupProject::startBackup($setting['name_db'], $setting['unset_dir_to_zip'], $setting['time_delete_zip'], $setting['name_prefix_dir_zip'], $messG);

    q(" INSERT INTO `admin_backup_project` SET
        `file_name`      = '".mres($return['file_name'])."',
        `volume_memory`  = '".mres(FBytes($return['volume_memory']))."',
        `user_custom`    = '".mres($_SESSION['user']['last_name'].' '.$_SESSION['user']['name'])."'
    ");

    sessionInfo('/admin/setting/backup/', $mess['Backup успішно зроблений!'], 1);
}

// Download last backup
if(isset($_REQUEST['downloadBackup'])){
    $backup = q("
        SELECT * FROM `admin_backup_project` ORDER BY `id` DESC LIMIT 1
    ")->fetch_assoc();

    $file = $_SERVER['DOCUMENT_ROOT'].'/uploaded/backup/'.$backup['file_name'];

    if(file_exists($file)){
        file_force_download($file);
    } else {
        sessionInfo('/admin/setting/backup/', $mess['Backup відсутній або видалений якщо термін зберігання застарілий!']);
    }
}

// Pagination
$backup = Pagination::formNav(array(
    'numPage'     => (!isset($_GET['numPage'])? 1 : (int)$_GET['numPage']),
    'count_show'  => 5,
    'records_el'  => 10,
    'url'         => "/admin/setting/backup/",
    'db_table'    => "admin_backup_project",
    'css_class'   => "pagination-admin",
    'filter'      => '',
    'sort'        => '',
    'seo'         => 'N',
    'notFound404' => 'N',
    'lang'        => '',
    'link_lang'   => '',
));