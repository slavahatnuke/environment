<?php

require_once 'autoload.php';

use Environment\Request\CliRequest;
use Environment\Environment;

$env = new Environment();
$env(new CliRequest());
