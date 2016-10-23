<?php
Core::$META['title'] = 'Student FAQs | World Class Evaluation Services';
Core::$META['keywords'] = 'credential evaluation, credential evaluation FAQ, credential evaluation FAQs, transcript evaluation, international students';
Core::$META['description'] = 'Frequently asked questions and answers for WCES applicants. How long does my evaluation take? How can I check status? How much does it cost? Which type of evaluation should I choose?';
unset($contentOG);

$arBlock = array(
    0 => array(
        'img'         => '/skins/default/img/st-gr.jpg',
        'alt_img'     => 'General Report',
        'name'        => 'General Report',
        'price'       => '$85',
        'description' => '<p>U.S. equivalence for each educational credential</p><br><p>Note: This report does not include an evaluation of individual courses, grades, or grade average (GPA)</p>'
    ),
    1 => array(
        'img'         => '/skins/default/img/st-dr.jpg',
        'alt_img'     => 'Detail Report',
        'name'        => 'Detail Report',
        'price'       => '$110',
        'description' => '<p>U.S. equivalence for each educational credential</p><br><p>Grade average for each university level credential</p><br><p>Note: If there is no university level study, a grade average for high school level study will be included</p>'
    ),
    2 => array(
        'img'         => '/skins/default/img/st-cbycr.jpg',
        'alt_img'     => 'Course-by-Course Report',
        'name'        => 'Course-by-Course Report',
        'price'       => '$135',
        'description' => '<p>U.S. equivalence for each educational credential</p><p>Credit and grade equivalents</p><p>Grade average for each educational credential</p><p>Identifies upper level courses for undergraduate or professional studies</p><p>General evaluation of high school level credentials (without a grade average), if included for evaluation</p>'
    ),
);