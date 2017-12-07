<?php
// Caricamento configurazione e utilita
//require_once('config.php');
require_once('lib/utilita.php');
require_once('lib/file.php');
require_once('lib/flashmessage.php');
Utilita::PARAMETRI_INIZIALI();

require("controllers/dashboard.php");
require("controllers/receive.php");
require("controllers/send.php");
require("controllers/stats.php");
require("controllers/saluta.php");
require("controllers/article.php");
require("controllers/todo.php");

require("lib/mysql.php");
require("lib/queries.php");
require("lib/route.php");
