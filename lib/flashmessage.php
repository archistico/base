<?php

class Flashmessage {

    public static function ADD($utente, $file, $titolo, $messaggio, $tipologia) {
        $name = $utente.'|'.$file;

        if(empty($_COOKIE[$name])) {
            setcookie($name, serialize([['titolo' => $titolo, 'messaggio' => $messaggio, 'tipologia' => $tipologia]]), time()+3600, "/");
        } else {
            setcookie($name, serialize([['titolo' => $titolo, 'messaggio' => $messaggio, 'tipologia' => $tipologia]]), time()+3600, "/");
        }
    }

    public static function READ($utente, $file) {
        $ret = [];
        // Cerca il session con utente e file
        $name = $utente.'|'.$file;
        
        // Se non è vuoto
        if(!empty($_COOKIE[$name])) {

            foreach(unserialize($_COOKIE[$name]) as $flash) {
                $titolo = $flash['titolo'];
                $messaggio = $flash['messaggio'];
                $tipologia = $flash['tipologia'];

                $ret[] = ['titolo' => $titolo, 'messaggio' => $messaggio, 'tipologia' => $tipologia];
            }

            setcookie($name, null, -1, '/');
        } 
       
        return $ret;
    }

    public static function COUNT($utente, $file) {
        $ret = 0;
        // Cerca il session con utente e file
        $name = $utente.'|'.$file;
        
        // Se non è vuoto
        if(!empty($_COOKIE[$name])) {

            foreach(unserialize($_COOKIE[$name]) as $flash) {
                $ret += 1;
            }
        } 
       
        return $ret;
    }
}