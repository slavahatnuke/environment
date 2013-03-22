<?php
namespace Hat\Environment\Handler\Request;

use Hat\Environment\Handler;
use Hat\Environment\Exception;

class RequireProfile extends Handler
{
    public function supports($data)
    {
        return !$data->has('profile');
    }

    protected function doHandle($request)
    {
        throw new Exception('--profile option is required');
    }

}
