<?php

error_reporting(E_ERROR);

require './framework/Application.php';

$app = Application::GetIstanza();
$app->run();
