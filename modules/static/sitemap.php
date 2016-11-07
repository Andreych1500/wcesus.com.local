<?php
Core::$META['title'] = 'World Class Evaluation Services - Site Map';
Core::$META['keywords'] = '';
Core::$META['description'] = '';
unset($contentOG);


$site_map = array(
    'Home'        => array(
        'this'         => '/',
        'About Us'     => '/static/about-us/',
        'Credentials'  => '/static/credentials/',
        'Office Hours' => '/static/office-hours/'
    ),
    'Students'    => array(
        'this'                => '/for-students/',
        'Educational Guide'   => '/for-students/educational-guide/',
        'Educational Systems' => '/for-students/educational-systems/',
        'Required Documents'  => '/for-students/required-documents/',
        'FAQ'                 => '/for-students/faq/'
    ),
    'Job Seekers' => array(
        'this'               => '/job-seekers/',
        'Employment Guide'   => '/job-seekers/employment-guide/',
        'Working in the USA' => '/job-seekers/working-usa/',
        'Required Documents' => '/job-seekers/required-documents/',
        'FAQ'                => '/job-seekers/faq/'
    ),
    'Immigrants'  => array(
        'this'               => '/immigrants/',
        'Immigration Guide'  => '/immigrants/immigration-guide/',
        'Coming to the USA'  => '/immigrants/coming-usa/',
        'Required Documents' => '/immigrants/required-documents/',
        'FAQ'                => '/immigrants/faq/'
    ),

    'Fees'                 => '/static/fees/',
    'Apply Now'            => '/apply/',
    'Cabinet'              => '/cab/',
    'Privacy Policy'       => '/static/privacy-policy/',
    'Terms and Conditions' => '/static/terms-conditions/',
    '404'                  => '/error/',
);