<?php
class BackupProject{
    static $allFiles = array(); // Глобальний массив з всіма файлами
    static $fileNotZip = array(); // Файли, які не попадають в архів
    static $dbNames = array(); // Массив баз даних які потраплять у архів
    static $dbFiles = array(); // Массив файлів з дампом баз даних
    static $delta = 500; // Крок
    static $return = array(
        'file_name'     => '',
        'volume_memory' => 0
    ); // Повернення даних

    static function startBackup($dbNames, $offsetDirs, $timeDirDelete, $namePrefix, $messG){
        set_time_limit(0); // Забираємо обмеження в часі

        self::$fileNotZip = explode(',', $offsetDirs);

        $dbNames = explode(',', $dbNames); // Массив получаємих баз даних

        foreach($dbNames as $v){
            self::$dbNames[] = $v;
        }

        /* Директорія з всіма файлами сайту. ВАЖЛИВО: Шляхи повинні бути фізичними, від корня.*/
        $source_dirs = $_SERVER['DOCUMENT_ROOT'];

        /* Директорія, куди будуть поміщатися архіви */
        $dump_dir = $_SERVER['DOCUMENT_ROOT']."/uploaded/backup";

        /* Службова змінна, що служить для усунення зайвих папок до корня */
        $offset_dirs = strlen($_SERVER['DOCUMENT_ROOT']) - strlen($_SERVER['HTTP_HOST']);

        /* Час в секундах через який будуть видалятися архіви*/
        $time_delete = $timeDirDelete * 86400;

        /* Iм'я архіву */
        $file_zip = $namePrefix."_".date("Y_m_d").".zip";
        self::$return['file_name'] = $file_zip;

        BackupProject::deleteOldArchive($dump_dir, $time_delete); // Видаленя попередніх архівів

        if(file_exists($dump_dir."/".$file_zip)){
            BackupProject::errorBackup($messG['Архів з таким ім\'ям вже існує!'], $dump_dir);
        }

        foreach(self::$dbNames as $dataBase){
            if(!q("SHOW DATABASES LIKE '".mres($dataBase)."'")->num_rows){
                BackupProject::errorBackup($messG['База даних з таким ім\'ям відсутня:'].$dataBase, $dump_dir);
            }
        }

        foreach(self::$dbNames as $k => $dataBase){
            self::$dbFiles[] = $dump_dir."/".$dataBase.".sql";
            $fp = fopen(self::$dbFiles[$k], "a"); // Відкриваємо файл або створюємо

            $result_set = q("SHOW TABLES"); // Запитуємо всі таблиці з бази

            while(($table = $result_set->fetch_assoc()) != false){

                /* Перебір всіх таблиць в базі даних */
                $table = current($table);
                $count = current(q("SELECT COUNT(*) FROM `".$table."`;")->fetch_assoc());
                $result = q("SHOW COLUMNS FROM `".$table."`;");

                if($fp){
                    $start = 0;
                    $result_set_table = q("SHOW CREATE TABLE `".$table."`;")->fetch_assoc();
                    $result_set_table = array_values($result_set_table);
                    $result_set_table[1] = preg_replace("#^CREATE TABLE#uis", "CREATE TABLE IF NOT EXISTS", $result_set_table[1]);

                    fwrite($fp, "--\n-- Structure table `".$table."`\n--\n\n".$result_set_table[1].";\n\n--\n-- Damp data base table`".$table."`\n--\n\n"); // Результат даних таблиці

                    if($count > 0){
                        $query = "INSERT INTO `".$table."` (";

                        $i = 0;
                        while($row = $result->fetch_assoc()){
                            $query .= (($i == 0)? '`'.$row['Field'].'`' : ', `'.$row['Field'].'`');
                            ++$i;
                        }
                        $query .= ") VALUES";
                    } else {
                        continue;
                    }

                    while($count > 0){
                        $result = q("SELECT * FROM `".$table."` LIMIT ".$start.", ".self::$delta.";");

                        while($row = $result->fetch_assoc()){
                            $query .= "\n(";
                            $j = 0;

                            foreach($row as $index => $field){
                                if (is_null($field)){
                                    $field = "NULL";
                                }

                                $query .= (($j == 0)? $field : ', "'.mres($field).'"');
                                ++$j;
                            }
                            $query .= '),';
                        }

                        $count -= self::$delta;
                        $start += self::$delta;
                    }

                    $query = trim($query, ',').";\n\n";
                    fwrite($fp, $query);
                } else {
                    BackupProject::errorBackup($messG['Виникла помилка при створенні ресурса!'], $dump_dir);
                }
            }

            fclose($fp);
            DB::close();
        }

        $zip = new ZipArchive();

        if($zip->open($dump_dir."/".$file_zip, ZipArchive::CREATE) === true){

            /* Рекурсивний перебір всіх директорій */
            if(is_dir($source_dirs)){
                BackupProject::recoursiveDir($source_dirs);
            } else {
                self::$allFiles[] = $source_dirs;
            }

            foreach(self::$allFiles as $val){
                /* Добавляем в ZIP-архив все полученные файлы */
                $unsetFile = substr($val, strlen($_SERVER['DOCUMENT_ROOT']));
                $local = substr($val, $offset_dirs);

                if($unsetFile == $offsetDirs){
                    continue;
                }

                self::$return['volume_memory'] += filesize($val);

                $zip->addFile($val, $local);
            }

            /* Добавляем в ZIP-архив все дампы баз данных */
            foreach(self::$dbFiles as $k => $value){
                $local = substr($value, strlen($dump_dir) + 1);
                $zip->addFile($value, $local);
            }

            $zip->close();
        }

        foreach(self::$dbFiles as $k => $value){ // Очищуємо маcсив
            unlink($value);
        }

        return self::$return;
    }

    static function recoursiveDir($dir){
        if($files = glob($dir."/{,.}*", GLOB_BRACE)){
            foreach($files as $file){
                $b_name = basename($file);

                if(in_array($b_name, self::$fileNotZip) || ($b_name == ".") || ($b_name == "..")){
                    continue;
                }

                if(is_dir($file)){
                    BackupProject::recoursiveDir($file);
                } else {
                    self::$allFiles[] = $file;
                }
            }
        }
    }

    static function deleteOldArchive($dump_dir, $delay_delete){
        $ts = time();
        $files = glob($dump_dir."/*.zip");
        foreach($files as $file){
            if($ts - filemtime($file) > $delay_delete){
                unlink($file);
            }
        }
    }

    static function errorBackup($text, $dump_dir){

        foreach(glob($dump_dir.'/*.sql') as $file){
            unlink($file);
        }

        sessionInfo('/admin/setting/backup/', $text);
    }
}