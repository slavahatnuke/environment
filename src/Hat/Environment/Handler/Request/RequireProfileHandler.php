<?php
namespace Hat\Environment\Handler\Request;

use Hat\Environment\Handler\Handler;
use Hat\Environment\Handler\HandlerException;

class RequireProfileHandler extends Handler
{
    public function supports($data)
    {
        return !$data->has('profile');
    }

    protected function doHandle($request)
    {
        throw new HandlerException('--profile option is required');
    }

}
