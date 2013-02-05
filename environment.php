<?php

require_once 'autoload.php';

use Environment\Request\CliRequest;
use Environment\Environment;

$env = new Environment();

$env->handle(
    new CliRequest(
        array(
            'profile' => 'Profile/os.ini'
        )
    )
);
