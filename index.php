<?php

error_reporting(E_ERROR);

require './framework/Application.php';
require './framework/Controller.php';

$configurazione = require './config/main.php';

$app = Application::GetIstanza($configurazione);
$app->run();