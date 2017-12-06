<?php

require("controllers/dashboard.php");
require("controllers/receive.php");
require("controllers/send.php");
require("controllers/stats.php");
require("controllers/saluta.php");
require("lib/mysql.php");
require("lib/queries.php");
require("lib/route.php");

RouteHook::add("404", function() {
    echo "Not found";
});

Route::serve(array(
    "/" => "Dashboard",
    "/send" => "Send",
    "/receive" => "Receive",
    "/stats" => "Stats",
    "/saluta" => "Saluta"
));
