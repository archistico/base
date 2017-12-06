<?php

class Flashmessage {
    public static function ADD($utente, $file, $titolo, $messaggio, $tipologia) {
        
    }

    public static function READ($utente, $file) {
        // Array di messaggi
        $ret = [];
        
        $titolo = 'Errore';
        $messaggio = 'Manca 1';
        $tipologia = 'ALERT';

        $ret[] = ['titolo' => $titolo, 'messaggio' => $messaggio, 'tipologia' => $tipologia];

        $titolo = 'Errore';
        $messaggio = 'Manca 2';
        $tipologia = 'ALERT';

        $ret[] = ['titolo' => $titolo, 'messaggio' => $messaggio, 'tipologia' => $tipologia];

        return $ret;
    }
}