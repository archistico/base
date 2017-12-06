<?php

class Dashboard {
    function get() {
        $stats = get_stats();
        include("views/dashboard.php");
    }
}