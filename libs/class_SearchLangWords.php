<?php
class SearchLangWords{
    static $arrLangFile = array();
    static $arrSearchWords = array();
    static $words = array();
    static $modules = array();

    static function search($patternLang, $patternSearch, $type){
        $allFile = $_SERVER['DOCUMENT_ROOT'];

        $getModule = q("
            SELECT `module`
            FROM `admin_module_pages`
        ");

        while($arResult = $getModule->fetch_assoc()){
            self::$modules[] = $arResult['module'];
        }

        SearchLangWords::langFile($allFile, $patternLang, $type);
        SearchLangWords::searchMess($allFile, $patternSearch);

        foreach(self::$arrSearchWords as $section => $arrM){
            if(!in_array($section, self::$modules)){
                foreach($arrM as $word){
                    if(!isset(self::$arrLangFile[$section]) || (isset(self::$arrLangFile[$section]) && !in_array($word, self::$arrLangFile[$section]))){
                        if(isset(self::$words[$section]) && in_array($word, self::$words[$section])){
                            continue;
                        } else {
                            self::$words[$section][] = $word;
                        }
                    }
                }
            } else {
                foreach($arrM as $mG => $v){
                    foreach($v as $word){
                        if($mG == 'arrMessG'){
                            if(!isset(self::$arrLangFile[$mG]) || (isset(self::$arrLangFile[$mG]) && !in_array($word, self::$arrLangFile[$mG]))){
                                if(isset(self::$words[$section][$mG]) && in_array($word, self::$words[$section][$mG])){
                                    continue;
                                } else {
                                    self::$words[$section][$mG][] = $word;
                                }
                            }
                        } else {
                            if(!isset(self::$arrLangFile[$section][$mG]) || (isset(self::$arrLangFile[$section][$mG]) && !in_array($word, self::$arrLangFile[$section][$mG]))){
                                if(isset(self::$words[$section][$mG]) && in_array($word, self::$words[$section][$mG])){
                                    continue;
                                } else {
                                    self::$words[$section][$mG][] = $word;
                                }
                            }
                        }
                    }
                }
            }
        }

        return self::$words;
    }

    static function searchMess($dir, $pattern){
        if($files = glob($dir.$pattern, GLOB_BRACE)){
            foreach($files as $file){
                if(basename(dirname($file)) == 'lang'){
                    continue;
                }

                if(in_array($section = basename(dirname($file)), self::$modules)){
                    preg_match_all('#(\$mess\[[^\$].+\]|\$messG.+\])#uisU', file_get_contents($file), $arrMess);
                    foreach($arrMess[0] as $v){
                        if(preg_match('#\$mess\[#uis', $v)){
                            self::$arrSearchWords[$section]['arrMess'][] = $v;
                        } elseif(preg_match('#\$messG\[\'#uis', $v)) {
                            self::$arrSearchWords[$section]['arrMessG'][] = $v;
                        }
                    }
                } else {
                    preg_match_all('#\$messG\[\'.+\]#uisU', file_get_contents($file), $arrMessG);
                    foreach($arrMessG[0] as $v){
                        self::$arrSearchWords['arrMessG'][] = $v;
                    }
                }
            }
        }

        return self::$arrSearchWords;
    }

    static function langFile($dir, $pattern, $type){
        if($files = glob($dir.$pattern, GLOB_BRACE)){
            foreach($files as $file){
                if($type == 'site' && basename(dirname(dirname($file))) == 'admin'){
                    continue;
                }

                if(in_array($section = basename(dirname(dirname($file))), self::$modules)){
                    preg_match_all('#\$mess\[[^\$].+\]#uisU', file_get_contents($file), $arrMess);
                    foreach($arrMess[0] as $v){
                        self::$arrLangFile[$section]['arrMess'][] = $v;
                    }
                } else {
                    preg_match_all('#\$messG\[\'.+\]#uisU', file_get_contents($file), $arrMessG);
                    foreach($arrMessG[0] as $v){
                        self::$arrLangFile['arrMessG'][] = $v;
                    }
                }
            }
        }

        return self::$arrLangFile;
    }
}