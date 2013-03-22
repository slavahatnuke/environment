<?php
namespace Hat\Environment\Handler\Request;

use Hat\Environment\Handler;

class Help extends Handler
{
    public function supports($data)
    {
        return !count($data) || $data->has('help');
    }

    protected function doHandle($request)
    {
        echo file_get_contents(__DIR__ . '/../../HELP'), "\n";
    }

}
