<?php
if(isset($_POST['ok']) && isset($_FILES['file'])){
    $option = array('new_import', 'replace_all', 'add_elements', 'add_csv_elements');
    $error = '';

    if($_FILES['file']['error'] > 0){
        $error = 'Сталася помилка при загрузці файла!';
    } else {
        preg_match("#.\w+$#uis",$_FILES['file']['name'], $matches);

        if(count($matches) <= 0){
            sessionInfo('/admin/setting/import-db/', 'Жодного типу файла не знайдено!');
        } elseif(!isset($_POST['what_option'])){
            sessionInfo('/admin/setting/import-db/', 'Помилка, виберіть вид імпорту!');
        } elseif(!in_array($_POST['what_option'], $option)){
            sessionInfo('/admin/setting/import-db/', 'Такої операції з імпортом не існує!');
        }
    }

    if($_POST['type_import'] == 'sql' && $matches[0] == '.sql'){
        $result = ImportDB::importSql($_FILES['file'], $_POST['what_option']);
        if(isset($result['error'])){
            sessionInfo('/admin/setting/import-db/', $mess[$result['error']]);
        }  else {
            sessionInfo('/admin/setting/import-db/', 'Імпорт пройшов успішно!', 1);
        }
    } elseif($_POST['type_import'] == 'csv' && $matches[0] == '.csv') {
        $result = ImportDB::importCsv($_FILES['file'], $_POST['what_option']);
        if(isset($result['error'])){
            sessionInfo('/admin/setting/import-db/', $mess[$result['error']]);
        }  else {
            sessionInfo('/admin/setting/import-db/', 'Імпорт пройшов успішно!', 1);
        }
    } else {
        sessionInfo('/admin/setting/import-db/', 'Файла з відповідним типом не знайдено!');
    }
}