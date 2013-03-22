<?php
namespace Hat\Environment;

use Hat\Environment\Kit\Kit;
use Hat\Environment\Kit\Service;

return array(

    'request.handler' => new Service(function (Kit $kit) {

        $handler = new \Hat\Environment\Handler\RequestHandler();

        $handler->addHandler(new \Hat\Environment\Handler\Request\HelpHandler());
        $handler->addHandler(new \Hat\Environment\Handler\Request\RequireProfileHandler());

        $handler->addHandler(new \Hat\Environment\Handler\Request\ExecuteProfileHandler(
                $kit->get('profile.loader'),
                $kit->get('profile.handler')
        ));

        return $handler;
    }),

    'profile.handler' => new Service(function (Kit $kit) {

        $handler = new \Hat\Environment\Handler\ProfileHandler($kit->get('definition.handler'));

        return $handler;
    }),

    'definition.handler' => new Service(function (Kit $kit) {

        $handler = new \Hat\Environment\Handler\DefinitionHandler();
        $handler->addHandler(new \Hat\Environment\Handler\Definition\ValidateHandler());

        return $handler;
    }),

    'profile.loader' => new Service(function (Kit $kit) {

        $loader = new ProfileLoader();

        return $loader;
    }),

    'request' => new Service(function (Kit $kit) {

        return new \Hat\Environment\Request\CliRequest(
            array(
                'profile' => 'environment.ini'
            )
        );

    }),

);
