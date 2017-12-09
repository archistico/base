<?php

class Logout {
    function get() {

        if(isset($_COOKIE[GLOBAL_COOKIENAME])) {
            unset($_COOKIE[GLOBAL_COOKIENAME]);
            setcookie(GLOBAL_COOKIENAME, null, -1, '/');
        }

        Flashmessage::Add('guest', 'login', 'Logout', 'Effettuato con successo', 'SUCCESS');

        // Rinvia alla pagina
        header("Location: /login");
    }
}

