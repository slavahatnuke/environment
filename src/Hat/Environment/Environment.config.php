<?php
namespace Hat\Environment;

use Hat\Environment\Kit\Kit;
use Hat\Environment\Kit\Service;

return array(

    'request.handler' => new Service(function (Kit $kit) {

        $handler = new RequestHandler();

        $handler->addHandler(new \Hat\Environment\Handler\Request\Help());
        $handler->addHandler(new \Hat\Environment\Handler\Request\RequireProfile());

        $handler->addHandler(new \Hat\Environment\Handler\Request\ExecuteProfile(
                $kit->get('profile.loader'),
                $kit->get('profile.handler')
        ));

        return $handler;
    }),

    'profile.handler' => new Service(function (Kit $kit) {

        $handler = new ProfileHandler();
//        $handler->addHandler(new \Hat\Environment\Handler\Request\Help());

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
