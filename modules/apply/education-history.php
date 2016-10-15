<?php
$keyPost = ApplyCard::param(2, array('keyPost'));
$param = array_merge(ApplyCard::param(2), ApplyCard::param('glob', array(
    'country_study',
    'date_yyyy_from',
    'date_yyyy_to',
    'date_mm_from',
    'date_mm_to'
)));

if(isset($_POST['add_history'], $_POST['update'])){
    $error = array();
    $file = array();
    $_POST = trimAll($_POST);

    if(!$data = ApplyCard::checkData()){
        sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
    }

    foreach($keyPost['keyPost'] as $v){
        if(!array_key_exists($v, $_POST)){
            $check[$v] = 'class="error"';
            break;
        }
    }

    if(isset($check)){
        $error['stop'] = 1;
    } else {
        $check['country_study'] = (empty($_POST['country_study']) || !isset($param['country_study'][$_POST['country_study']])? 'class="error"' : '');
        $check['city'] = (empty($_POST['city'])? 'class="error"' : '');
        $check['name_institution'] = (empty($_POST['name_institution'])? 'class="error"' : '');
        $check['date_mm_from'] = (empty($_POST['date_mm_from']) || !isset($param['date_mm_from'][$_POST['date_mm_from']])? 'class="error"' : '');
        $check['date_yyyy_from'] = (empty($_POST['date_yyyy_from']) || !isset($param['date_yyyy_from'][$_POST['date_yyyy_from']])? 'class="error"' : '');
        $check['date_mm_to'] = (empty($_POST['date_mm_to']) || !isset($param['date_mm_to'][$_POST['date_mm_to']])? 'class="error"' : '');
        $check['date_yyyy_to'] = (empty($_POST['date_yyyy_to']) || !isset($param['date_yyyy_to'][$_POST['date_yyyy_to']])? 'class="error"' : '');
        $check['reason_text'] = (strlen($_POST['reason_text']) > 1000? 'class="error"' : '');

        if(($_POST['date_yyyy_from'] == $_POST['date_yyyy_to']) && $_POST['date_mm_from'] > $_POST['date_mm_to']){
            $check['date_mm_from'] = 'class="error"';
            $check['date_mm_to'] = 'class="error"';
        } elseif($_POST['date_yyyy_from'] > $_POST['date_yyyy_to']) {
            $check['date_yyyy_from'] = 'class="error"';
            $check['date_yyyy_to'] = 'class="error"';
        }

        $check['fileScan'] = (emptyArray($_POST['fileScan'])? 'error' : '');

        if(in_array('class="error"', $check) || in_array('error', $check)){
            $error['stop'] = 1;
        }
    }

    if(!count($error)){
        $_POST = mres($_POST);

        $card = q("
            SELECT `id`, `idCard`, `idCardHash`
            FROM `admin_application_info`
            WHERE `id` = '".$_POST['update']."'
            AND `idCardHash` = '".mres($data['idCardHash'])."'
            LIMIT 1
        ");

        if(isset($_GET['edit']) && $card->num_rows > 0){
            $arResult = hsc($card->fetch_assoc());

            foreach($_POST['fileScan'] as $k => $v){
                if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                    rename($_SERVER['DOCUMENT_ROOT'].$v, $_SERVER['DOCUMENT_ROOT'].'/uploaded/scan/'.basename($v));
                    $file['fileScan'][$k] = '/uploaded/scan/'.basename($v);
                }
            }

            $scan = trim(implode('#|#', $file['fileScan']), '#|#');

            q("
                UPDATE `admin_educational_history` SET
                `country_study`    = '".$_POST['country_study']."',
                `city`             = '".$_POST['city']."',
                `name_institution` = '".$_POST['name_institution']."',
                `date_mm_from`     = '".$_POST['date_mm_from']."',
                `date_yyyy_from`   = '".$_POST['date_yyyy_from']."',
                `date_mm_to`       = '".$_POST['date_mm_to']."',
                `date_yyyy_to`     = '".$_POST['date_yyyy_to']."',
                `fileScan`         = '".mres($scan)."',
                `diploma_name`     = '".$_POST['diploma_name']."',
                `reason_text`      = '".$_POST['reason_text']."'
                WHERE `id`   = '".mres($_GET['edit'])."'
                AND `idCard` = '".mres($arResult['idCard'])."' 
            ");

            setcookie('idCardHash', $arResult['idCardHash'], time() + 3600, '/');
            header('Location: '.(isset($_GET['review'])? '/apply/education-history/?review=back' : '/apply/education-history/').'');
            exit();
        } elseif(isset($_GET['edit']) && $card->num_rows <= 0) {
            sessionInfo('/apply/education-history/', '<p>Wrong WCES ID, access denied!</p>');
        }

        if($card->num_rows <= 0){
            sessionInfo('/apply/education-history/', '<p>Wrong WCES ID, linking is forbidden!</p>', 0, 0);
        } else {
            $arResult = hsc($card->fetch_assoc());

            foreach($_POST['fileScan'] as $k => $v){
                if(!empty($v) && file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
                    rename($_SERVER['DOCUMENT_ROOT'].$v, $_SERVER['DOCUMENT_ROOT'].'/uploaded/scan/'.basename($v));
                    $file['fileScan'][$k] = '/uploaded/scan/'.basename($v);
                }
            }

            $scan = trim(implode('#|#', $file['fileScan']), '#|#');

            q("
                INSERT INTO `admin_educational_history` SET
                    `idCard`           = '".mres($arResult['idCard'])."',
                    `country_study`    = '".$_POST['country_study']."',
                    `city`             = '".$_POST['city']."',
                    `name_institution` = '".$_POST['name_institution']."',
                    `date_mm_from`     = '".$_POST['date_mm_from']."',
                    `date_yyyy_from`   = '".$_POST['date_yyyy_from']."',
                    `date_mm_to`       = '".$_POST['date_mm_to']."',
                    `date_yyyy_to`     = '".$_POST['date_yyyy_to']."',
                    `fileScan`         = '".mres($scan)."',
                    `diploma_name`     = '".$_POST['diploma_name']."',
                    `reason_text`      = '".$_POST['reason_text']."',
                    `date_create`      = NOW()
            ");

            setcookie('idCardHash', $arResult['idCardHash'], time() + 3600, '/');
            header('Location: '.(isset($_GET['review'])? '/apply/education-history/?review=back' : '/apply/education-history/').'');
            exit();
        }
    }
}

// Ajax
if(isset($_GET['getType']) && isset($_GET['ajax']) && isset($_POST['data-priority-type'])){
    echo(isset($_FILES['file'])? json_encode(UploaderFiles::getType($_FILES['file'], $_POST['data-priority-type'])) : json_encode(array('error' => 'Limit file memory!')));
    exit();
} elseif(isset($_GET['ajax']) && isset($_GET['addImage']) && isset($_FILES['file'])) {
    echo json_encode(UploaderFiles::photo($_FILES['file']));
    exit();
} elseif(isset($_GET['delFile']) && !empty($_POST['file_delete'])) {
    if(file_exists($_SERVER['DOCUMENT_ROOT'].$_POST['file_delete'])){
        unlink($_SERVER['DOCUMENT_ROOT'].$_POST['file_delete']);
        echo json_encode(array('file' => 'delete'));
    } else {
        echo json_encode(array('error' => 'no files'));
    }
    exit();
}

if($data = ApplyCard::checkData()){

    if(isset($_POST['ok'])){
        $step2 = q("
            SELECT *
            FROM `steps_ok_cards`
            WHERE `idCard` = '".mres($data['idCard'])."'
            AND `step2` = 1
            LIMIT 1
        ");

        if($step2->num_rows == 0){
           sessionInfo('/apply/education-history/', '<p>Please fill in at least one educational history!</p>');
        }

        setcookie('idCardHash', $data['idCardHash'], time() + 3600, '/');
        header('Location: '.(isset($_GET['review'])? '/apply/review/' : '/apply/purpose/').'');
        exit();
    }

    foreach($keyPost['keyPost'] as $v){
        if(!isset($_POST[$v])){
            if($v == 'fileScan'){
                $_POST[$v] = explode('#|#', '');
                continue;
            }

            $_POST[$v] = '';
        }
    }

    $_POST['update'] = $data['id'];

    $getHistory = q("
        SELECT *
        FROM `admin_educational_history`
        WHERE `idCard` = '".mres($data['idCard'])."'
    ");

    q("
        UPDATE `steps_ok_cards` SET
        `step2`   = ".($getHistory->num_rows > 0? 1 : 0)."
        WHERE `idCard` = '".mres($data['idCard'])."'
    ");
} else {
    sessionInfo('/apply/', '<p>Time is out. Please log in to your account to continue your application.</p>');
}

if(isset($_GET['remove'])){
    $editHistory = q("
        SELECT `fileScan`
        FROM `admin_educational_history`
        WHERE `idCard` = '".mres($data['idCard'])."'
        AND `id` = '".mres($_GET['remove'])."'
        LIMIT 1
    ")->fetch_assoc();

    foreach(explode('#|#', $editHistory['fileScan']) as $v){
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
            unlink($_SERVER['DOCUMENT_ROOT'].$v);
        }
    }

    q("
        DELETE FROM `admin_educational_history`
        WHERE `id` = ".(int)$_GET['remove']."
        AND `idCard` = '".mres($data['idCard'])."'
    ");

    header('Location: '.(isset($_GET['review'])? '/apply/education-history/?review=back' : '/apply/education-history/').'');
    exit();
}

if(isset($_GET['edit'])){
    $editHistory = q("
        SELECT *
        FROM `admin_educational_history`
        WHERE `idCard` = '".mres($data['idCard'])."'
        AND `id` = '".mres($_GET['edit'])."'
        LIMIT 1
    ");

    if($editHistory->num_rows > 0){
        foreach($editHistory->fetch_assoc() as $k => $v){
            if($k == 'fileScan'){
                foreach(explode("#|#", $v) as $k2 => $file){
                    $_POST[$k][$k2] = $file;
                }
                continue;
            }

            $_POST[$k] = $v;
        }
    } else {
        sessionInfo('/apply/education-history/', '<p>Wrong WCES ID, access denied!</p>');
    }
}

Core::$JS[] = "<script src=\"/skins/default/js/education-history.min.js\" defer></script>";