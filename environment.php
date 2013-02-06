<?php

require_once 'autoload.php';

use Hat\Environment\Request\CliRequest;
use Hat\Environment\Environment;

$env = new Environment();

$env->handle(
    new CliRequest(
        array(
            'profile' => 'Profile/os.ini'
        )
    )
);
