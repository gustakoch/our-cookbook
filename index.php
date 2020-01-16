<?php

require_once "vendor/autoload.php";

date_default_timezone_set('America/Recife'); // SEM HORÁRIO DE VERÃO
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$start = new App\Router;
