<?php

class Home {
    function get() {
        /* ----------------------------------------
         *      AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */
        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        include("views/home.php");
    }
}