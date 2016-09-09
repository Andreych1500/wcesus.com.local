<?php
class AdminFunction {
    static $error = '';
    static $result = array(
        'html_filter'    => '',
        'setting_option' => array(),
        'count_el_page'  => '',
        'pagination'     => '',
        'result_DB'      => '',
        'column_list'    => array()
    );

    static function check_DB($db_table, $url){
        $issetTable = q("
            SHOW TABLES FROM `".Core::$DB_NAME."` 
            LIKE '".mres($db_table)."'
        ");

        if(!$issetTable->num_rows){
            sessionInfo($url, 'Error: no param table '.mres($db_table).'; ');
        } else {
            return true;
        }
    }

    static function deleteEl($ids, $db_table, $url, $mess){
        if(self::check_DB($db_table, $url)){
            $arSel = q("
                SELECT *
                FROM `".$db_table."`
                WHERE `id` IN (".$ids.")
            ");

            if(!$arSel->num_rows){
                sessionInfo($url, 'Error, ID not exist!');
            }

            // Delete file
            while($arResult = $arSel->fetch_assoc()){
                foreach($arResult as $k => $v){
                    if(preg_match_all('#\/uploaded\/[\w\/]+\.(jpeg|jpg|png|gif)#uis', $v, $matches) > 0){
                        foreach($matches[0] as $file){
                            if(file_exists($_SERVER['DOCUMENT_ROOT'].$file)){
                                unlink($_SERVER['DOCUMENT_ROOT'].$file);
                            }
                        }
                    }
                }

                clearstatcache();

                q("
                    DELETE FROM `".$db_table."`
                    WHERE `id` = ".(int)$arResult['id']."
                ");
            }

            sessionInfo($url, $mess, 1);
        }
    }

    static function deactivateEl($ids, $db_table, $url, $mess){
        if(self::check_DB($db_table, $url)){
            q(" 
                UPDATE `".$db_table."` 
                SET `active` = 0
                WHERE `id` IN (".$ids.")
            ");

            sessionInfo($url, $mess, 1);
        }
    }

    static function activeEl($ids, $db_table, $url, $mess){
        if(self::check_DB($db_table, $url)){
            q(" 
                UPDATE `".$db_table."` 
                SET `active` = 1
                WHERE `id` IN (".$ids.")
            ");

            sessionInfo($url, $mess, 1);
        }
    }

    static function StructureMenu($arParam){
        if(self::check_DB($arParam['db_table'], $arParam['url'])){
            self::filter($arParam);

            return self::$result;
        }
    }

    static function filter($arParam){
        include './libs/lang_filter/inp_lang_'.$_COOKIE['lang_admin'].'.php';

        $formation = array();
        $urlParamFilter = '';
        $columns = q("SHOW COLUMNS FROM `".$arParam['db_table']."`");

        $column_info = q("
            SELECT *
            FROM `".str_replace('admin', 'setting', $arParam['db_table'])."`
        ");

        while($row = hsc($column_info->fetch_assoc())){
            $arCheckFilter[] = $row['field'];

            $formation[$row['field']] = $row;
            unset($formation[$row['field']]['field']);
        }

        while($row = $columns->fetch_assoc()){
            self::$result['column_list'][] = $row['Field'];
            $formation[$row['Field']]['key'] = $row['Key'];
        }

        if($arParam['filter']){
            foreach($_GET as $field => $v){
                if(preg_match_all("#^find_(\w+)#uis", $field, $matches)){
                    $urlParamFilter .= $field.'='.$v.'&';

                    if(preg_match_all("#(\w+)(_last|_first)$#uis", current($matches[1]), $code)){
                        if(isset($formation[current($code[1])]['filter'])){
                            $formation[current($code[1])]['filter'] .= '|#|'.$v;
                        } else {
                            $formation[current($code[1])]['filter'] = $v;
                        }
                        continue;
                    }

                    if(in_array(current($matches[1]), $arCheckFilter)){
                        $formation[current($matches[1])]['filter'] = $v;
                    }
                }
            }

            $urlParamFilter .= 'filter='.$_GET['filter'];
        }

        // html formation
        $i = 0;
        foreach($formation as $k => $ar){
            ++$i;
            $name = hsc($ar['name_'.$_COOKIE['lang_admin']]);
            $value = (isset($formation[$k]['filter'])? hsc($formation[$k]['filter']) : '');
            $act = (!empty($filter[$k]) || (isset($_COOKIE['filter']) && in_array($i - 1, (array)json_decode($_COOKIE['filter'])))? 'act-option' : '');
            $disabled = (!empty($filter[$k]) || (isset($_COOKIE['filter']) && in_array($i - 1, (array)json_decode($_COOKIE['filter'])))? '' : 'disabled');

            // Formation symbol code column and setting
            self::$result['setting_column'][$k] = array(
                'index'       => $i - 1,
                'name'        => $name,
                'key'         => $ar['key'],
                'view_table'  => $ar['view_table'],
                'view_filter' => $ar['view_filter'],
                'edit_window' => $ar['edit_window_menu'],
                'field'       => $ar['input_type'],
                'type'        => $ar['filter_type']
            );

            if(!$ar['view_filter']){
                continue;
            }

            if($ar['input_type'] == 'number'){
                if($ar['filter_type'] == 'range'){
                    $value = explode('|#|', $value);

                    if(!isset($value[1])){
                        $value[1] = '';
                    }

                    self::$result['html_filter'] .= '<div class="input-value '.$act.'" data-index="'.($i - 1).'">
                                                       <div class="name-section">'.$name.':</div>
                                                       <div class="range">
                                                         <input '.$disabled.' type="number" name="find_'.$k.'_first" value="'.$value[0].'">
                                                         <span class="free-point">...</span>
                                                         <input '.$disabled.' type="number" name="find_'.$k.'_last" value="'.$value[1].'">
                                                       </div>
                                                     </div>';
                } else {
                    self::$result['html_filter'] .= '<div class="input-value '.$act.'" data-index="'.($i - 1).'">
                                                       <div class="name-section">'.$name.':</div>
                                                       <input '.$disabled.' type="number" name="find_'.$k.'" value="'.$value.'">
                                                     </div>';
                }

                continue;
            }

            if($ar['input_type'] == 'tinyint'){
                if($ar['filter_type'] == 'select'){
                    self::$result['html_filter'] .= '<div class="input-value '.$act.'" data-index="'.($i - 1).'">
                                                       <div class="name-section">'.$name.':</div>
                                                       <select '.$disabled.' name="find_'.$k.'">';

                    foreach($inpMess[$k] as $v => $text){
                        self::$result['html_filter'] .= '<option value="'.$v.'" '.(($value == $v && strlen($v) == strlen($value))? 'selected' : '').'>'.$text.'</option>';
                    }

                    self::$result['html_filter'] .= '</select></div>';
                }
                continue;
            }

            if($ar['input_type'] == 'text'){
                self::$result['html_filter'] .= '<div class="input-value '.$act.'" data-index="'.($i - 1).'">
                                                   <div class="name-section">'.$name.':</div>
                                                   <input '.$disabled.' type="text" name="find_'.$k.'" value="'.$value.'">
                                                 </div>';
                continue;
            }

            if($ar['input_type'] == 'email'){
                self::$result['html_filter'] .= '<div class="input-value '.$act.'" data-index="'.($i - 1).'">
                                                   <div class="name-section">'.$name.':</div>
                                                   <input '.$disabled.' type="email" name="find_'.$k.'" value="'.$value.'">
                                                 </div>';
                continue;
            }

            if($ar['input_type'] == 'datetime'){
                if($ar['filter_type'] == 'range'){
                    $value = explode('|#|', $value);

                    if(!isset($value[1])){
                        $value[1] = '';
                    }

                    self::$result['html_filter'] .= '<div class="input-value '.$act.'" data-index="'.($i - 1).'">
                                                       <div class="name-section">'.$name.':</div>
                                                       <div class="range">
                                                         <input '.$disabled.' type="datetime-local" name="find_'.$k.'_first" value="'.$value[0].'">
                                                         <span class="free-point">...</span>
                                                         <input '.$disabled.' type="datetime-local" name="find_'.$k.'_last" value="'.$value[1].'">
                                                       </div>
                                                     </div>';
                }
            }
        }

        // Query formation
        $whereQuery = 'WHERE';

        foreach($formation as $column => $value){
            if(isset($value['filter']) && mb_strlen($value['filter']) > 0 && $ar['view_filter']){
                if(mb_strlen($whereQuery) > 5 && $value['filter'] != '|#|'){
                    $whereQuery .= ' AND';
                }

                if($value['input_type'] == 'text' || $value['input_type'] == 'email'){
                    $whereQuery .= ' `'.$column.'` LIKE \'%'.mres($value['filter']).'%\'';
                } elseif($value['input_type'] == 'number') {
                    if($value['filter_type'] == 'range'){
                        $value = explode('|#|', $value['filter']);

                        if(strlen($value[0]) == 0 && strlen($value[1]) == 0){
                            continue;
                        } elseif(empty($value[0])) {
                            $whereQuery .= ' `'.$column.'` BETWEEN 0 AND '.(int)$value[1].'';
                        } elseif(empty($value[1])) {
                            $whereQuery .= ' `'.$column.'` = '.(int)$value[0];
                        } else {
                            $whereQuery .= ' `'.$column.'` BETWEEN '.(int)$value[0].' AND '.(int)$value[1];
                        }
                    }
                } elseif($value['input_type'] == 'tinyint') {
                    $whereQuery .= ' `'.$column.'` = '.mres($value['filter']).'';
                } elseif($value['input_type'] == 'datetime') {
                    $value = explode('|#|', str_replace('T', ' ', $value['filter']));

                    if(strlen($value[0]) == 0 && strlen($value[1]) == 0){
                        continue;
                    } elseif(empty($value[0])) {
                        $whereQuery .= ' `'.$column.'` BETWEEN \'1970-01-01 00:00\' AND \''.mres($value[1]).'\'';
                    } elseif(empty($value[1])) {
                        $whereQuery .= ' `'.$column.'` > \''.mres($value[0]).'\'';
                    } else {
                        $whereQuery .= ' `'.$column.'` BETWEEN \''.mres($value[0]).'\' AND \''.mres($value[1]).'\'';
                    }
                }
            }
        }

        if($whereQuery == 'WHERE'){
            $whereQuery = '';
        }

        // Count el pages
        $arCountElements = array(200, 100, 50, 20, 10);
        $countElements = (isset($_COOKIE['count_el_page']) && in_array((int)$_COOKIE['count_el_page'], $arCountElements)? (int)$_COOKIE['count_el_page'] : 20);

        self::$result['count_el_page'] = '<div class="count_el_page">
                                            <div class="view_count">'.$countElements.'</div>
                                            <div class="selected">';

        foreach($arCountElements as $count){
            if($countElements != $count){
                self::$result['count_el_page'] .= '<span>'.$count.'</span>';
            }
        }

        self::$result['count_el_page'] .= '</div></div>';

        // Pagination
        $getPage = (($_GET['page'] == 'main')? '\/' : '\/'.$_GET['page'].'\/');

        if(!preg_match("#\/".$_GET['module'].$getPage."#uisU", $arParam['url'])){
            self::$result = 'Error: no param url '.$arParam['url'].'; ';
        } else {
            $active = $arParam['numPage']; // номер активної сторінки
            $count_show = $arParam['pagination']['count_show']; // кількість порядкових сторінок які виводяться у пагінаії
            $url = (empty($urlParamFilter)? $arParam['url'] : $arParam['url'].'?'.$urlParamFilter); // url сторінки від корня
            $urlParamFilter = (empty($urlParamFilter)? '' : '&'.$urlParamFilter);

            // Кількість усіх записів /
            $all_element = q("
                SELECT `id`
                FROM `".$arParam['db_table']."`
                ".$whereQuery."
            ")->num_rows;

            $count_pages = ceil($all_element / $countElements);

            if($count_pages > 1){
                $left = $active - 1;
                $right = $count_pages - $active;

                if($left < floor($count_show / 2)){
                    $start = 1;
                } else {
                    $start = $active - floor($count_show / 2);
                }

                $end = $start + $count_show - 1;

                if($end > $count_pages){
                    $start -= ($end - $count_pages);
                    $end = $count_pages;
                    if($start < 1){
                        $start = 1;
                    }
                }

                if($arParam['numPage'] > $count_pages || $arParam['numPage'] <= 0){
                    header('Location: '.$arParam['url']);
                    exit();
                }

                // html pagination
                ob_start();
                echo '<div class="pagination-admin">';
                if($active != 1){
                    echo '<a href="'.(($active == 2)? $url : $arParam['url'].'?numPage='.($active - 1)).$urlParamFilter.'">&lt;</a>';
                }

                for($i = $start; $i <= $end; $i++){
                    if($i == $active){
                        echo '<span class="act-nav">'.$i.'</span>';
                    } else {
                        echo '<a href="'.(($i == 1)? $url : $arParam['url'].'?numPage='.$i).$urlParamFilter.'">'.$i.'</a>';
                    }
                }

                if($active != $count_pages){
                    echo '<a href="'.$arParam['url'].'?numPage='.($active + 1).$urlParamFilter.'">&gt;</a>';
                }
                echo '</div>';

                self::$result['pagination'] = ob_get_contents();
                ob_get_clean();

                // Get Elements
                $start_el = ($arParam['numPage'] - 1) * (int)$countElements;

                self::$result['result_DB'] = q("
                    SELECT *
                    FROM `".$arParam['db_table']."`
                    ".$whereQuery."
                    ORDER BY `sort` DESC, `id` DESC
                    LIMIT ".$start_el.", ".(int)$countElements."
                ");
            } else {
                if(isset($_GET['numPage'])){
                    header('Location: '.$url);
                    exit();
                } else {

                    self::$result['result_DB'] = q("
                        SELECT * 
                        FROM `".$arParam['db_table']."` 
                        ".$whereQuery." 
                        ORDER BY `sort` DESC, `id` DESC
                    ");

                    self::$result['pagination'] = '<div class="pagination-admin"><span class="act-nav">1</span></div>';
                }
            }
        }
    }

    static function dynamicEditHtml($param, $db_table, $url){
        if(self::check_DB($db_table, $url)){
            $field = array();
            $htmlEl = array();
            $ids = implode(',', $param['id']);
            $what = '`id`,';

            $column_info = q("
                SELECT *
                FROM `".str_replace('admin', 'setting', $db_table)."`
            ");

            while($arResult = hsc($column_info->fetch_assoc())){
                if($arResult['edit_window_menu']){
                    $field[$arResult['field']] = $arResult['input_type'];
                    $what .= '`'.$arResult['field'].'`,';
                }
            }

            $what = trim($what, ',');

            if(count($field) <= 0){
                echo json_encode(array('error' => 'Sorry, no edit field this table!'));
                exit();
            }

            include './libs/lang/lang_'.$_COOKIE['lang_admin'].'.php';

            // Get element
            $arQuery = q("
                SELECT ".$what."
                FROM ".$db_table."
                WHERE `id` IN (".$ids.")
            ");

            // html formation
            while($arResult = hsc($arQuery->fetch_assoc())){
                foreach($field as $k => $v){
                    if($v == 'text'){
                        $htmlEl[$arResult['id']][$k] = '<input type="text" name="arr['.$arResult['id'].']['.$k.']" value="'.$arResult[$k].'">';
                    } elseif($v == 'email') {
                        $htmlEl[$arResult['id']][$k] = '<input type="email" name="arr['.$arResult['id'].']['.$k.']" value="'.$arResult[$k].'">';
                    } elseif($v == 'number') {
                        $htmlEl[$arResult['id']][$k] = '<input min="1" type="number" name="arr['.$arResult['id'].']['.$k.']" value="'.$arResult[$k].'">';
                    } elseif($v == 'tinyint') {
                        $htmlEl[$arResult['id']][$k] = '<select name="arr['.$arResult['id'].']['.$k.']">';

                        foreach($mess[$k] as $v1 => $text){
                            $htmlEl[$arResult['id']][$k] .= '<option value="'.$v1.'" '.(($arResult[$k] == $v1 && strlen($v1) == strlen($arResult[$k]))? 'selected' : '').'>'.$text.'</option>';
                        }

                        $htmlEl[$arResult['id']][$k] .= '</select>';
                    }
                }
            }

            echo json_encode(array('html' => $htmlEl));
            exit();
        }
    }

    static function dynamicEditQuery($arEl, $db_table, $url, $mess){

        if(self::check_DB($db_table, $url)){
            $field = array();
            $when = array();
            $ids = '';
            $query = '';
            $select_column = '';
            $arPrimary_column = array();

            $columns = q("SHOW COLUMNS FROM `".$db_table."`");
            while($row = $columns->fetch_assoc()){
                $field[$row['Field']] = (($row['Key'] == 'PRI' || $row['Key'] == 'UNI')? 'Y' : 'N');
                $select_column .= (($row['Key'] == 'PRI' || $row['Key'] == 'UNI')? '`'.$row['Field'].'`, ' : '');
            }

            $select_column = trim($select_column, ', ');
            $arPrimary = q("
                SELECT ".$select_column."
                FROM `".$db_table."`
            ");

            while($row = hsc($arPrimary->fetch_assoc())){
                $arPrimary_column[] = $row;
            }

            foreach($arEl as $k => $array){
                foreach($array as $name => $value){
                    if(array_key_exists($name, $field)){
                        $when[$name][$k] = $value;
                    }
                }

                $ids .= $k.',';
            }

            // No update admin №1
            if($db_table == 'admin_users_list' && $_SESSION['user']['id'] != 1 && preg_match("#^1,{1}#uis", $ids)){
                sessionInfo($url, $mess[1]);
            }

            $ids = trim($ids, ',');

            foreach($field as $k => $value){
                if($value == 'Y' && isset($when[$k])){
                    foreach(array_count_values($when[$k]) as $primary){
                        if($primary > 1){
                            sessionInfo($url, $k.' primary key!');
                        }
                    }

                    foreach($arPrimary_column as $k2 => $v2){
                        if(current($when[$k]) == $v2[$k]){
                            sessionInfo($url, $k.' primary key!');
                        }
                    }
                }
            }

            // Formation query
            foreach($when as $colum => $arrayId){
                $query .= "`".$colum."` = CASE ";
                foreach($arrayId as $id => $value){
                    $query .= " WHEN `id` = ".$id." THEN '".mres($value)."'";
                }
                $query .= " END,";
            }

            q("
                UPDATE `".$db_table."` SET
                ".$query."
                `user_custom` = '".mres($_SESSION['user']['last_name'].''.$_SESSION['user']['name'])."'
                 WHERE `id` IN (".$ids.")
            ");

            sessionInfo($url, $mess, 1);
        }
    }
}