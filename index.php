<?php

require_once('loader.php');

RouteHook::add("404", function() {
    echo "<h1>Errore 404</h1>Risorsa non disponibile";
});


Route::serve(Routes::getInstance()->Load()->getRoutes());
