<?php
// Caricamento configurazione e utilita
//require_once('config.php');
require_once('lib/utilita.php');
require_once('lib/file.php');
require_once('lib/flashmessage.php');
Utilita::PARAMETRI_INIZIALI();

require("controllers/home.php");
require("controllers/todo.php");

require("lib/mysql.php");
require("lib/route.php");
