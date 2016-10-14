<?php

$main_banner = q("
    SELECT *
    FROM `admin_main_banner`
    WHERE `active` = 1 ORDER BY `sort` DESC, `id` DESC
");