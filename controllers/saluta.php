<?php

class Saluta {
    function get() {
        // Carica tutti i dati che servono nella vista
        $chi = "Emilie";
        include("views/saluta.php");
    }
}