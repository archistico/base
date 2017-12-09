<?php

require_once('loader.php');
define('DIR', __DIR__);
define('GLOBAL_COOKIENAME', "Base");

RouteHook::add("404", function() {
    echo "<h1>Errore 404</h1>Risorsa non disponibile";
});


Route::serve(array(

    "/" => "Home",
    "/notauthorized" => "NotAuthorized",
    "/todo" => "Todo",
    "/todoadd" => "TodoAdd",
    "/todo/delete/:number" => "TodoDelete",
    "/todo/modify/:number" => "TodoModify",
    "/login" => "Login",
    "/logout" => "Logout",
    "/utente" => "Utente",
    "/utente/delete/:number" => "UtenteDelete",
    "/utente/modify/:number" => "UtenteModify",

));
