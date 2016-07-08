<?php

error_reporting(E_ERROR | E_CORE_ERROR);

require './framework/Application.php';
require './framework/Controller.php';
require './framework/TabellaDatabase.php';

$configurazione = require './config/main.php';

$app = Application::GetIstanza($configurazione);
$app->run();