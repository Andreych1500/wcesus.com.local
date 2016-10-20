<?php
$GM = hsc(q("
    SELECT *
    FROM `admin_module_pages`
    WHERE `module` = 'error'
    AND `active` = 1
    LIMIT 1
")->fetch_assoc());

foreach(explode(',', $GM['list_length']) as $k => $v){
    if($lang == 'en'){
        Core::$META['title'] = hsc(explode('#|#', $GM['meta_title'])[$k]);
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

$menu = array(
    'Home'        => array(
        'this'        => '/',
        'About Us'    => '/static/about-us/',
        'Credentials' => '/static/credentials/'
    ),
    'Students'    => array(
        'this'               => '/for-students/',
        'Required Documents' => '/for-students/required-documents/',
        'FAQ'                => '/for-students/faq/'
    ),
    'Job Seekers' => array(
        'this'               => '/job-seekers/',
        'Required Documents' => '/job-seekers/required-documents/',
        'FAQ'                => '/job-seekers/faq/'
    ),
    'Immigrants'  => array(
        'this'               => '/immigrants/',
        'Required Documents' => '/immigrants/required-documents/',
        'FAQ'                => '/immigrants/faq/'
    ),
    'Fees'                 => '/static/fees/',
    'Apply Now'            => '/apply/',
);