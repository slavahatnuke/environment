<?php
require_once 'autoload.php';

$environment = new Hat\Environment\Environment();

$environment->getKit()->apply(array(
//    'default.profile.name' => 'xxx.ini'
));

$environment();
