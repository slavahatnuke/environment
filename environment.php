<?php

require_once 'autoload.php';

$env = new \Environment\Environment(__DIR__ . '/Profile/');
$env->test('os.ini');

