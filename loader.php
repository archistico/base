<?php
// Caricamento configurazione e librerie
require_once('config.php');
require_once('lib/utilita.php');
require_once('lib/file.php');
require_once('lib/flashmessage.php');
require_once('lib/autaut.php');
require_once('lib/accesso.php');

Utilita::PARAMETRI_INIZIALI();

// Caricamento controller
require("controllers/controller.php");
require("controllers/home.php");
require("controllers/todo.php");
require("controllers/utente.php");
require("controllers/login.php");
require("controllers/logout.php");
require("controllers/notauthorized.php");

// Entities
require("entities/todo.php");
require("entities/utente.php");

// Database e route
require("lib/mysql.php");
require("lib/route.php");
