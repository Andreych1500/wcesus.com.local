<?php
// Information session
if (isset($_SESSION['info'])) {
    foreach ($_SESSION['info'] as $key => $value) {
        $info[$key] = $value;
    }
    unset($_SESSION['info']);
}