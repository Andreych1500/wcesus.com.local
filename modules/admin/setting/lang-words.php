<?php
if(isset($_POST['ok'])){

    $type = 'site';
    $patternLang = "/modules/{lang/lang_*".$_POST['lang'].".php,*/lang/lang_".$_POST['lang'].".php}";
    $patternSearch = "/{modules/{*.php,*/*.php},skins/default/{*.tpl,*/*.tpl}}";

    if(preg_match('#admin#uis', $_POST['template'])){
        $type = 'admin';
        $patternLang = "/modules/admin/{lang/lang_*".$_POST['lang'].".php,*/*/lang_*".$_POST['lang'].".php}";
        $patternSearch = "/{modules{/*.php,/admin/{*.php,*/*.php}},skins/admin/{*.tpl,*/*.tpl}}";
    }

    $words = SearchLangWords::search($patternLang, $patternSearch, $type);

    if(count($words) < 1){
        sessionInfo('/admin/setting/lang-words/', $mess['Неперекладених слів не знайдено!'], 1);
    }
}