<?php

require_once 'autoload.php';

use Environment\Request\CliRequest;
use Environment\Environment;

$env = new Environment();
$env(new CliRequest()); // CliRequest=Request=InputInterface, Response=OutputInterface

//setup handling context
//create environment tester with suitable context
//environment tester should test profile
//
