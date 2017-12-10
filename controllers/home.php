<?php

class Home {
    function get() {
        /* ----------------------------------------
         *      AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */
        Autaut::CHECK_CREDENTIAL(Routes::getInstance()->Load()->getCredential(get_class()));

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        include("views/home.php");
    }
}