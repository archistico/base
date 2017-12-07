<?php

require_once('loader.php');
define('DIR', __DIR__);

RouteHook::add("404", function() {
    echo "<h1>Errore 404</h1>Risorsa non disponibile";
});

Route::serve(array(
    "/" => "Dashboard",
    "/send" => "Send",
    "/receive" => "Receive",
    "/stats" => "Stats",
    "/saluta" => "Saluta",
    "/article/:number" => "Article",
    "/article/delete/:number" => "ArticleDelete",
    "/todo" => "Todo",
    "/todoadd" => "Todoadd",

));
