<?php
Core::$META['title'] = 'Required Documents Job Seekers | World Class Evaluation Services';
Core::$META['keywords'] = '';
Core::$META['description'] = 'Issued with the letterhead, has an original institutional seal';
unset($contentOG);

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
        echo json_encode(array('error' => 'Error: Country with this code was not found!'));
        exit();
    }
}

$getEl = q("
    SELECT `name`, `code`
    FROM `admin_country_doc`
    WHERE `active` = 1
    ORDER BY `sort` ASC
");