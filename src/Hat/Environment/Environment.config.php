<?php
namespace Hat\Environment;

use Hat\Environment\Kit\Kit;
use Hat\Environment\Kit\Service;
use Hat\Environment\Request\CliRequest;

return array(

    'request.handler' => new Service(function (Kit $kit) {
        return new RequestHandler();
    }),

    'request' => new Service(function (Kit $kit) {

        return new CliRequest(
            array(
                'profile' => 'environment.ini'
            )
        );
    }),

);
