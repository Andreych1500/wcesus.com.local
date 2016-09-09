<?php
class ImportDB {
    static function importSql($files, $param){
        preg_match("#(.+).\w+$#uisU", $files['name'], $matches);

        $issetTable = q("
            SHOW TABLES FROM `".Core::$DB_NAME."` 
            LIKE '".mres($matches[1])."'
        ");

        $sqlSource = file_get_contents($_FILES['file']['tmp_name']);

        if($param == 'new_import'){
            if(!$issetTable->num_rows){
                q($sqlSource, 1);
            } else {
                return array('error' => 'Невірна операція імпорту, таблиця вже існує!');
            }
        } elseif($param == 'replace_all') {
            if(!$issetTable->num_rows){
                return array('error' => 'Невірна операція імпорту, таблиці не знайдено!');
            } else {
                $sqlSource = preg_replace("#INSERT INTO#uis", "REPLACE INTO", $sqlSource);
                $sqlSource = preg_replace("#(.+)REPLACE INTO#uis", "REPLACE INTO", $sqlSource);

                q($sqlSource, 1);
            }
        } elseif($param == 'add_elements') {
            if(!$issetTable->num_rows){
                return array('error' => 'Невірна операція імпорту, таблиці не знайдено!');
            } else {
                preg_match("#INSERT INTO.+\);#uisU", $sqlSource, $matches);

                if(count($matches) > 0){
                    $find = array("#INSERT INTO#uis", "#\(.+\, #uisU");
                    $replace = array("INSERT IGNORE INTO", "(");

                    $sqlSource = preg_replace($find, $replace, $matches[0]);
                } else {
                    return array('error' => 'Сталась невідома помилка!');
                }

                q($sqlSource);
            }
        }
    }

    static function importCsv($files, $param){
        preg_match("#(.+).\w+$#uisU", $files['name'], $matches);

        $issetTable = q("
            SHOW TABLES FROM `".Core::$DB_NAME."`
            LIKE '".mres($matches[1])."'
        ");

        $all_lines = file($files['tmp_name'], FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        if($param == 'add_csv_elements'){
            if(!$issetTable->num_rows){
                return array('error' => 'Не вірна операція імпорту, таблиці не знайдено!');
            } else {
                $sqlSource = 'INSERT IGNORE INTO `'.$matches[1].'` (';

                foreach($all_lines as $k => $query) {
                    if($k == 0){
                        foreach(explode(';', $query) as $v){
                            $sqlSource .= '`'.$v.'`, ';
                        }

                        $sqlSource = trim($sqlSource, ', ');

                        $sqlSource .= ') VALUES ';
                        continue;
                    }

                    $value = '(';
                    foreach(explode(';', $query) as $v){
                        $value .= '\''.$v.'\', ';
                    }
                    $value = trim($value, ', ');

                    $sqlSource .= $value.'), ';
                }

                $sqlSource = trim($sqlSource, ', ');
                $sqlSource .= ';';

                q($sqlSource);
            }
        }
    }
}