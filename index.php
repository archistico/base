<?php

require("handlers/dashboard_handler.php");
require("handlers/receive_handler.php");
require("handlers/send_handler.php");
require("handlers/stats_handler.php");
require("handlers/saluta_handler.php");
require("lib/mysql.php");
require("lib/queries.php");
require("lib/route.php");

RouteHook::add("404", function() {
    echo "Not found";
});

Route::serve(array(
    "/" => "DashboardHandler",
    "/send" => "SendHandler",
    "/receive" => "ReceiveHandler",
    "/stats" => "StatsHandler",
    "/saluta" => "SalutaHandler"
));
