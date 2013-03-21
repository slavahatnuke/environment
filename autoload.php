<?php
require_once 'src/Hat/Environment/ClassLoader.php';

new Hat\Environment\ClassLoader(__DIR__ . '/src');

require_once 'vendor/autoload.php';
