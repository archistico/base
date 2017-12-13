<?php

class Home extends Controller {
    function __construct() {
        parent::__construct(get_class());
    }

    function get() {
        include("views/home.php");
    }
}