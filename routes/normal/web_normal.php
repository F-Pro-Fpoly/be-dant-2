<?php
$api->get("/", function() {
    return "web normal";
});

require_once __DIR__."/page.php";
require_once __DIR__."/Specialist.php";
require_once __DIR__."/Setting.php";
require_once __DIR__."/User.php";

?>
