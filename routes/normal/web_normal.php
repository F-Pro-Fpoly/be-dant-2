<?php
$api->get("/", function() {
    return "web normal";
});

require_once __DIR__."/page.php";
require_once __DIR__."/Specialist.php";
require_once __DIR__."/Setting.php";
require_once __DIR__."/User.php";
require_once __DIR__."/schedule.php";
require_once __DIR__."/city.php";
require_once __DIR__."/district.php";
require_once __DIR__."/ward.php";
require_once __DIR__."/news.php";
?>
