<?php
class Autaut {
    public static function CHECK_CREDENTIAL($admitted_role) {
        if(self::AUTENTICATO()) {
            // SE E' AUTENTICATO
            if(!self::AUTORIZZATO($admitted_role)) {
                // SE NO E' AUTORIZZATO
                Utilita::REDIRECT("error.php");
            }
        } else {
            // SE NON E' AUTENTICATO
            Utilita::REDIRECT("login.php");
        }
    }
    public static function AUTENTICATO() {
        // Cerco la stringa che è nel cookie
        // Controllo che l'ip sia lo stesso
        // Guardo se è più vecchia di un giorno
        // restituisco true se c'è false se non c'è
        if(Accesso::EXIST($_COOKIE[GLOBAL_COOKIENAME], Utilita::GET_CLIENT_IP())) {
            return true;
        } else {
            return false;
        }
    }
    public static function AUTORIZZATO($admitted_role) {
        // $admitted_role is array
        $utenteruolo = Accesso::RUOLO($_COOKIE[GLOBAL_COOKIENAME], Utilita::GET_CLIENT_IP());
        if(in_array($utenteruolo, $admitted_role)) {
            return true;
        } else {
            return false;
        }
    }
    public static function LOGGATO() {
        // Ritorna il utentefk in base al cookiename
        return Accesso::UTENTEFK($_COOKIE[GLOBAL_COOKIENAME], Utilita::GET_CLIENT_IP());
    }
    public static function LOGGATO_RUOLO() {
        // Ritorna il ruolo in base al cookiename
        return Accesso::RUOLO($_COOKIE[GLOBAL_COOKIENAME], Utilita::GET_CLIENT_IP());
    }
}