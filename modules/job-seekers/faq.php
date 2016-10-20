<?php
Core::$META['title'] = 'Job Seekers FAQs | World Class Evaluation Services';
Core::$META['keywords'] = 'credential evaluation, credential evaluation FAQ, credential evaluation FAQs, transcript evaluation, international job seekers';
Core::$META['description'] = 'Frequently asked questions and answers for WCES applicants. How long does my evaluation take? How much does it cost? Which type of evaluation should I choose? How can I check status?';
unset($contentOG);

// 'Students' = 1
// 'Job Seekers' = 2
// 'Immigrants' = 3

$faq = array();

$getEl = q("
    SELECT *
    FROM `admin_faq`
    WHERE `type_faq` = 2
    AND `active` = 1
");

if($getEl->num_rows > 0){
    while($row = hsc($getEl->fetch_assoc())){
        $row['answer'] = preg_replace("#\#img\|(.+)\|(.+)\##uisU", '<img src="/uploaded/faq/$1" alt="$2"><div class="clear"></div>', $row['answer']);
        $row['answer'] = preg_replace("#\#link\|(.+)\|(.+)\##uisU", '<a href="$1" title="$2">$2</a>', $row['answer']);

        $faq[] = $row;
    }
}
