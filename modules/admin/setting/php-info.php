<?php
ob_start();
phpinfo();
$phpInfo = ob_get_contents();
ob_end_clean();
$phpInfo = preg_replace('#(body.+)(a:.+;}).(a:.+;})(.+)#umsU', '', $phpInfo);