<?php

class Home {
    function get() {
        /* ----------------------------------------
         *      AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */
        Autaut::CHECK_CREDENTIAL(['Amministratore','Normale', 'Visitatore']);
        $utentefk = Autaut::LOGGATO();

        $filename_corrente = File::FILENAME(__FILE__);
        $csrfname = $filename_corrente.":".$utentefk.":csrf";

        /* ----------------------------------------
         *   FINE AUTENTICAZIONE / AUTORIZZAZIONE
         * ----------------------------------------
        */

        include("views/home.php");
    }
}