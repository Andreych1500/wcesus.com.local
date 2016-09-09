<?php
class ExportDB{
    static $tables = array();

    static function table_structureXls($tables, $dir){
        require_once($_SERVER['DOCUMENT_ROOT'].'/libs/PHPExcel/Classes/PHPExcel.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/libs/PHPExcel/Classes/PHPExcel/Writer/Excel5.php');

        foreach($tables as $table){
            $table = mres($table);



            $xls = new PHPExcel();

            // Устанавливаем индекс активного листа
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();

            $sheet->setTitle('Table');

            // Вставляем текст в ячейку A1
            $sheet->setCellValue("A2", 'Table `'.$table.'`');

            $sheet->getStyle('A2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $sheet->getStyle('A2')->getFill()->getStartColor()->setRGB('EEEEEE');

            $i = 4;
            $select = q("SELECT * FROM `".$table."`");

            while($row = hsc($select->fetch_assoc())){

                $j = 0;
                foreach($row as $column => $value){
                    if($i == 4){
                        $sheet->setCellValueByColumnAndRow($j, $i-1, $column);
                        $sheet->getStyleByColumnAndRow($j, $i-1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    }

                    $sheet->setCellValueByColumnAndRow($j, $i, $value);

                    //Выравнивание текста
                    $sheet->getStyleByColumnAndRow($j, $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    ++$j;
                }

                ++$i;
            }

            $last_letter = ExportDB::getNameFromNumber($j);
            $last_plus_one = ExportDB::getNameFromNumber($j + 1);

            // Объединяем ячейки
            $sheet->mergeCells('A2:'.$last_letter.'2');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array(
                            'rgb' => '#2A8CFD'
                        )
                    )
                )
            );

            $xls->getActiveSheet()->getStyle('A2:'.$last_letter.'2')->applyFromArray($styleArray);
            unset($styleArray);

            // Create Logo
            $img = q("
            SELECT `brandPhoto`
            FROM `admin_personal_interface`
            LIMIT 1
        ")->fetch_assoc();

            $sheet->mergeCells('A1:'.$last_letter.'1');
            $imagePath = $_SERVER['DOCUMENT_ROOT'].$img['brandPhoto'];

            if (file_exists($imagePath)) {
                $logo = new PHPExcel_Worksheet_Drawing();
                $logo->setPath($imagePath);
                $logo->setCoordinates("A1");
                $logo->setOffsetX(10);
                $logo->setOffsetY(10);
                $sheet->getRowDimension(1)->setRowHeight(125);
                $logo->setWorksheet($sheet);
            }

            for($col = 'A'; $col !== $last_plus_one; $col++) {
                $sheet->getColumnDimension($col)->setWidth(15);
            }

            // Выводим содержимое файла
            $objWriter = new PHPExcel_Writer_Excel5($xls);
            $objWriter->save($_SERVER['DOCUMENT_ROOT'].'/uploaded/db_tables/'.$table.'.xls');

            ExportDB::goToZip($table, $dir, 'xls');
        }

        return true;
    }

    static function getNameFromNumber($num){
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);
        if($num2 > 0){
            return ExportDB::getNameFromNumber($num2).$letter;
        } else {
            return $letter;
        }
    }

    static function table_dataCsv($table, $dir){
        $csv_file = '';
        $delta = 500; // Кількість записів за один раз
        $start = 0;

        $count = current(q("SELECT COUNT(*) FROM `".$table."`;")->fetch_assoc());
        $result = q("SHOW COLUMNS FROM `".$table."`;");

        $i = 0;
        while($row = $result->fetch_assoc()){
            $csv_file .= (($i == 0)? ''.$row["Field"].'' : ';'.$row["Field"].'');
            ++$i;
        }
        $csv_file .= "\r\n";

        while($count > 0){
            $result = q("SELECT * FROM `".$table."` LIMIT ".$start.", ".$delta.";");

            while($row = $result->fetch_assoc()){
                $j = 0;
                foreach($row as $index => $field){
                    $csv_file .= (($j == 0)? ''.mres($field).'' : ';'.mres($field).'');
                    ++$j;
                }
                $csv_file .= "\r\n";
            }
            $count -= $delta;
            $start += $delta;
        }

        file_put_contents($dir.$table.'.csv', $csv_file, FILE_APPEND);
    }

    static function table_structureMySql($table, $dir){
        $content = "DROP TABLE IF EXISTS `".$table."`;\n\n";
        $result = q("SHOW CREATE TABLE `".$table."`;")->fetch_assoc();
        $content .= $result['Create Table'].";\n\n";

        file_put_contents($dir.$table.'.sql', $content);
    }

    static function table_dataMySql($table, $dir){
        $table = mres($table);
        $count = current(q("SELECT COUNT(*) FROM `".$table."`;")->fetch_assoc());
        $delta = 500; // Кількість записів за один раз
        $start = 0;

        if($count > 0){
            $result = q("SHOW COLUMNS FROM `".$table."`;");

            $content = "INSERT INTO `".$table."` (";
            $i = 0;
            while($row = $result->fetch_assoc()){
                $content .= (($i == 0)? '`'.$row['Field'].'`' : ', `'.$row['Field'].'`');
                ++$i;
            }
            $content .= ") VALUES";

            while($count > 0){
                $result = q("SELECT * FROM `".$table."` LIMIT ".$start.", ".$delta.";");

                while($row = $result->fetch_assoc()){
                    $content .= "\n(";
                    $j = 0;
                    foreach($row as $index => $field){
                        $content .= (($j == 0)? $field : ', \''.mres($field).'\'');
                        ++$j;
                    }
                    $content .= '),';
                }
                $count -= $delta;
                $start += $delta;
            }
            $content = trim($content, ',').";\n\n";

            file_put_contents($dir.$table.'.sql', $content, FILE_APPEND);
        }
    }

    static function goToZip($table, $dir, $file){
        $zip = new ZipArchive();
        if($zip->open($dir.'tables.zip', ZipArchive::CREATE) === true){
            $offset_dirs = strlen($_SERVER['DOCUMENT_ROOT']) - strlen($_SERVER['HTTP_HOST']);
            $table = $dir.$table.'.'.$file;
            $local = substr($table, strlen($dir));
            $zip->addFile($table, $local);
            $zip->close();

            if(file_exists($table)){
                unlink($table);
            }
        }
    }

    static function removeLastFile($dir){
        if($objs = glob($dir."*")){
            foreach($objs as $obj){
                is_dir($obj)? removeDirectory($obj) : unlink($obj);
            }
        }
    }

    static function getTable($name_db){
        $arResult = q("SHOW TABLES FROM `".mres($name_db)."`");
        while($table = $arResult->fetch_assoc()){
            self::$tables[] = current($table);
        }

        return self::$tables;
    }
}