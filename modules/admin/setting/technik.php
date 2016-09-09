<?php
$arResult = hsc(q("
    SELECT *
    FROM `admin_personal_interface`
    WHERE `id` = 1
")->fetch_assoc());