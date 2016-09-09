<?php
$GM = hsc(q("
    SELECT *
    FROM `admin_module_pages`
    WHERE `module` = 'error'
    AND `active` = 1
    LIMIT 1
")->fetch_assoc());

foreach(explode(',', $GM['list_length']) as $k => $v){
    if($lang == $v){
        Core::$META['title'] = hsc(explode('#|#', $GM['meta_title'])[$k]);
        Core::$META['keywords'] = hsc(explode('#|#', $GM['meta_title'])[$k]);
        Core::$META['description'] = hsc(explode('#|#', $GM['meta_title'])[$k]);
    }
}

// New file version
$vF = q('SELECT `new_resource` FROM `admin_site_cache` WHERE `id` = 1')->fetch_assoc()['new_resource'];

if(isset($_SERVER['REDIRECT_STATUS']) && $_SERVER['REDIRECT_STATUS'] == 403){
    header('HTTP/1.0 403 Forbidden');
    $status_error = 403;
} else {
    $_SERVER['REDIRECT_STATUS'] = 404;
    $_SERVER['REDIRECT_REDIRECT_STATUS'] = 404;
    $status_error = 404;
}