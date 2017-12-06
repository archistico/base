<?php

require_once('loader.php');

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
