<?php

error_reporting(E_ERROR);

require './framework/Application.php';
require './framework/Controller.php';

$app = Application::GetIstanza();
$app->run();
