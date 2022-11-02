<?php
$api -> get('/', function() {
    return "web auth";
});


require_once __DIR__."/user.php";
require_once __DIR__."/sick.php";
require_once __DIR__."/vaccine.php";
require_once __DIR__."/specialist.php";
require_once __DIR__."/booking.php";
require_once __DIR__."/department.php";
require_once __DIR__."/role.php";
require_once __DIR__."/page.php";
require_once __DIR__."/count.php";
require_once __DIR__."/schedule.php";
require_once __DIR__."/setting.php";

?>