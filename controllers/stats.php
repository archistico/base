<?php

class Stats {
    function get_xhr() {
        echo json_encode(get_stats());
    }
}