<?php

require 'vendor/autoload.php';

use TurtleApp\TelegramBot;

$token = 'YOUR_BOT_TOKEN';
$bot = new TelegramBot($token);

$update = json_decode(file_get_contents('php://input'), true);
$bot->processUpdate($update);
