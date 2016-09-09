<?php
if(isset($_POST['ok'])){
    if(count($_POST['tables']) > 0){
        if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploaded/db_tables')){
            mkdir($_SERVER['DOCUMENT_ROOT'].'/uploaded/db_tables');
        }

        $dir = $_SERVER['DOCUMENT_ROOT'].'/uploaded/db_tables/';
        ExportDB::removeLastFile($dir);

        if($_POST['export'] == 'mysql'){
            foreach($_POST['tables'] as $table){
                ExportDB::table_structureMySql($table, $dir);
                ExportDB::table_dataMySql($table, $dir);
                ExportDB::goToZip($table, $dir, 'sql');
            }
        } elseif($_POST['export'] == 'csv'){
            foreach($_POST['tables'] as $table){
               ExportDB::table_dataCsv($table, $dir);
               ExportDB::goToZip($table, $dir, 'csv');
            }
        } elseif($_POST['export'] == 'xls'){
            ExportDB::table_structureXls($_POST['tables'], $dir);
        } else {
            sessionInfo('/admin/setting/export-db/', $messG['Виникла помилка при створенні ресурса!']);
        }

        $_SESSION['tables'] = $dir.'tables.zip';
        sessionInfo('/admin/setting/export-db/', $mess['Експорт даних пройшов успішно!'], 1);
    } else {
        sessionInfo('/admin/setting/export-db/', $mess['Жодної таблиці не було вибрано!']);
    }
}

if(isset($_REQUEST['download'])){
    if(!empty($_SESSION['tables']) && file_exists($_SESSION['tables'])){
        $file = $_SESSION['tables'];
        unset($_SESSION['tables']);
        file_force_download($file);
    } else {
        sessionInfo('/admin/setting/export-db/', $mess['Жодної таблиці не було знайдено!']);
    }
}

if(isset($_REQUEST['ajax'])){
    $tables = ExportDB::getTable(Core::$DB_NAME);
    if(count($tables) > 0){
        echo json_encode($tables);
    } else {
        echo json_encode(array('error' => 'No tables'));
    }
    exit();
}