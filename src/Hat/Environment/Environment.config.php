<?php
namespace Hat\Environment;

use Hat\Environment\Kit\Kit;
use Hat\Environment\Kit\Service;

return array(


    // options
    'default.profile.name' => 'environment.ini',



    //services

    'request.handler' => new Service(function (Kit $kit) {

        $handler = new \Hat\Environment\Handler\RequestHandler();

        $handler->addHandler(new \Hat\Environment\Handler\Request\HelpHandler());
//        $handler->addHandler(new \Hat\Environment\Handler\Request\DefineProfileHandler());
        $handler->addHandler(new \Hat\Environment\Handler\Request\RequireProfileHandler());

        $handler->addHandler(new \Hat\Environment\Handler\Request\HandleProfileHandler(
                $kit->get('profile.loader'),
                $kit->get('profile.handler')
        ));

        return $handler;
    }),





    'profile.handler' => new Service(function (Kit $kit) {

        $handler = new \Hat\Environment\Handler\ProfileHandler(
            $kit->get('definition.handler'),
            $kit->get('profile.loader')
        );

        return $handler;
    }),





    'definition.handler' => new Service(function (Kit $kit) {

        $handler = new \Hat\Environment\Handler\DefinitionHandler();
        $handler->addHandler(new \Hat\Environment\Handler\Definition\ValidateHandler());
        $handler->addHandler(new \Hat\Environment\Handler\Definition\HandleCommandHandler($kit));

        return $handler;
    }),





    'profile.loader' => new Service(function (Kit $kit) {

        $loader = new \Hat\Environment\Loader\ProfileLoader();

        return $loader;
    }),





    'request' => new Service(function (Kit $kit) {

        return new \Hat\Environment\Request\CliRequest(
            array(
                'profile' => $kit->get('default.profile.name')
            )
        );

    }),


    // end services


);
