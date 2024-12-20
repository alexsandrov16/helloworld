<?php

use Al3x5\xBot\xBot;

require 'vendor/autoload.php';

$config=require_once 'config.php';

$bot = new xBot($config);
$bot->run();
