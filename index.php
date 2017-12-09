<?php

require_once('loader.php');
define('DIR', __DIR__);

RouteHook::add("404", function() {
    echo "<h1>Errore 404</h1>Risorsa non disponibile";
});


Route::serve(array(

    "/" => "Home",
    "/todo" => "Todo",
    "/todoadd" => "TodoAdd",
    "/todo/delete/:number" => "TodoDelete",
    "/todo/modify/:number" => "TodoModify",
    "/login" => "Login",
    "/logout" => "Logout",
    "/utente" => "Utente",

));
