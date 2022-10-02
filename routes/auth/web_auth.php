<?php
$api -> get('/', function() {
    return "web auth";
});


require_once __DIR__."/user.php";
require_once __DIR__."/sick.php";
require_once __DIR__."/vaccine.php";
?>