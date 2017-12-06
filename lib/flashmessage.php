<?php

class Flashmessage {
    public static function ADD($utente, $file, $titolo, $messaggio, $tipologia) {
        $name = $utente.'|'.$file;
        if(empty($_SESSION[$name])) {
            $_SESSION[$name] = ['titolo' => $titolo, 'messaggio' => $messaggio, 'tipologia' => $tipologia];
        }        
    }

    public static function READ($utente, $file) {
        $ret = [];
        // Cerca il session con utente e file
        $name = $utente.'|'.$file;
        
        // Se non è vuoto
        if(!empty($_SESSION[$name])) {
            $titolo = $_SESSION[$name['titolo']];
            $messaggio = $_SESSION[$name['messaggio']];
            $tipologia = $_SESSION[$name['tipologia']];
    
            $ret[] = ['titolo' => $titolo, 'messaggio' => $messaggio, 'tipologia' => $tipologia];
    
        } 
       
        return $ret;
    }
}