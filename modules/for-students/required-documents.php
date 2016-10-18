<?php

if(isset($_GET['ajax'], $_POST['code']) && !empty($_POST['code'])){

    $getDoc = q("
        SELECT `documents`
        FROM `admin_country_doc`
        WHERE `code` = '".mres($_POST['code'])."'
        LIMIT 1
    ");

    if($getDoc->num_rows > 0){
        $document = hsc($getDoc->fetch_assoc()['documents']);

        echo json_encode(array('doc' => $document));
        exit();
    } else {
        echo json_encode(array('error' => 'Країни з таким кодовим словом не знайдено!'));
        exit();
    }
}

$getEl = q("
    SELECT `name`, `code`
    FROM `admin_country_doc`
    WHERE `active` = 1
    ORDER BY `sort` ASC
");