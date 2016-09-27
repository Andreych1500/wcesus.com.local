<?php
if(isset($_POST['add_history'], $_POST['update'])){
    $error = array();
    $file = array();
    $_POST = trimAll($_POST);

    if(!$data = ApplyCard::checkData()){
        sessionInfo('/cab/apply-user/', '<p>час зберігання даних вийшов, увійдіть знов у свій кабінет і заповніть дані!</p>');
    } else {
        $globPost = ApplyCard::param(2, 'globPost');
    }

    foreach($globPost as $v){
        if(!array_key_exists($v, $_POST)){
            $check['POST'] = 'class="error"';
            break;
        }
    }

    if(isset($check['POST'])){
        $error['stop'] = 1;
    } else {
        $check['country_study'] = (strlen($_POST['country_study']) == 0 || !isset(ApplyCard::param(2, 'country_study')[$_POST['country_study']])? 'class="error"' : '');
        $check['city'] = (empty($_POST['city'])? 'class="error"' : '');
        $check['name_institution'] = (empty($_POST['name_institution'])? 'class="error"' : '');
        $check['date_mm_from'] = (strlen($_POST['date_mm_from']) == 0 || !in_array($_POST['date_mm_from'], ApplyCard::param(2, 'date_mm_from'))? 'class="error"' : '');
        $check['date_yyyy_from'] = (strlen($_POST['date_yyyy_from']) == 0 || !in_array($_POST['date_yyyy_from'], ApplyCard::param(2, 'date_yyyy_from'))? 'class="error"' : '');
        $check['date_mm_to'] = (strlen($_POST['date_mm_to']) == 0 || !in_array($_POST['date_mm_to'], ApplyCard::param(2, 'date_mm_to'))? 'class="error"' : '');
        $check['date_yyyy_to'] = (strlen($_POST['date_yyyy_to']) == 0 || !in_array($_POST['date_yyyy_to'], ApplyCard::param(2, 'date_yyyy_to'))? 'class="error"' : '');
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

        if(isset($_REQUEST['edit']) && $card->num_rows > 0){
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
                WHERE `id`   = '".mres($_REQUEST['edit'])."'
                AND `idCard` = '".mres($arResult['idCard'])."' 
            ");

            setcookie('idCardHash', $arResult['idCardHash'], time() + 3600, '/');
            header('Location: '.(isset($_REQUEST['review'])? '/cab/education-history/?review=back' : '/cab/education-history/').'');
            exit();
        } elseif(isset($_REQUEST['edit']) && $card->num_rows <= 0) {
            sessionInfo('/cab/education-history/', '<p>Редагування неможливо, неіснує ID історії!</p>');
        }

        if($card->num_rows <= 0){
            sessionInfo('/cab/education-history/', '<p>Привязка неможлива, неіснує ID карточки!</p>', 0, 0);
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
            header('Location: '.(isset($_REQUEST['review'])? '/cab/education-history/?review=back' : '/cab/education-history/').'');
            exit();
        }
    }
}

// Ajax
if(isset($_REQUEST['getType']) && isset($_REQUEST['ajax']) && isset($_POST['data-priority-type'])){
    echo(isset($_FILES['file'])? json_encode(UploaderFiles::getType($_FILES['file'], $_POST['data-priority-type'])) : json_encode(array('error' => 'Limit file memory!')));
    exit();
} elseif(isset($_REQUEST['ajax']) && isset($_REQUEST['addImage']) && isset($_FILES['file'])) {
    echo json_encode(UploaderFiles::photo($_FILES['file']));
    exit();
} elseif(isset($_REQUEST['delFile']) && !empty($_POST['file_delete'])) {
    if(file_exists($_SERVER['DOCUMENT_ROOT'].$_POST['file_delete'])){
        unlink($_SERVER['DOCUMENT_ROOT'].$_POST['file_delete']);
        echo json_encode(array('file' => 'delete'));
    } else {
        echo json_encode(array('error' => 'no files'));
    }
    exit();
}

if($data = ApplyCard::checkData()){
    $globPost = ApplyCard::param(2, 'globPost');
    $param = ApplyCard::param(2);

    foreach($globPost as $v){
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
} else {
    sessionInfo('/cab/apply-user/', '<p>Щоб перейти у цей розділ розпочніть нову анкету або продовжіть існуючу, або час очікування закінчився.</p>');
}

if(isset($_POST['ok'])){
    setcookie('idCardHash', $data['idCardHash'], time() + 3600, '/');
    header('Location: '.(isset($_REQUEST['review'])? '/cab/review/' : '/cab/purpose/').'');
    exit();
}

if(isset($_REQUEST['edit'])){
    $editHistory = q("
        SELECT *
        FROM `admin_educational_history`
        WHERE `idCard` = '".mres($data['idCard'])."'
        AND `id` = '".mres($_REQUEST['edit'])."'
        LIMIT 1
    ");

    if($editHistory->num_rows > 0){
        foreach(hsc($editHistory->fetch_assoc()) as $k => $v){
            if($k == 'fileScan'){
                foreach(explode("#|#", $v) as $k2 => $file){
                    $_POST[$k][$k2] = $file;
                }
                continue;
            }

            $_POST[$k] = $v;
        }
    } else {
        sessionInfo('/cab/education-history/', '<p>Неіснує такої історії у вашої карточки</p>');
    }
}

if(isset($_REQUEST['remove'])){
    $editHistory = q("
        SELECT `fileScan`
        FROM `admin_educational_history`
        WHERE `idCard` = '".mres($data['idCard'])."'
        AND `id` = '".mres($_REQUEST['remove'])."'
        LIMIT 1
    ")->fetch_assoc();

    foreach(explode('#|#', $editHistory['fileScan']) as $v){
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$v)){
            unlink($_SERVER['DOCUMENT_ROOT'].$v);
        }
    }

    q("
        DELETE FROM `admin_educational_history`
        WHERE `id` = ".(int)$_REQUEST['remove']."
        AND `idCard` = '".mres($data['idCard'])."'
    ");

    header('Location: '.(isset($_REQUEST['review'])? '/cab/education-history/?review=back' : '/cab/education-history/').'');
    exit();
}

Core::$JS[] = "<script src=\"/skins/default/js/education-history.min.js\" defer></script>";