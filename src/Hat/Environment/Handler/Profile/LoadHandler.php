<?php
namespace Hat\Environment\Handler\Profile;

use Hat\Environment\Profile;
use Hat\Environment\Handler\PlainHandler;

class LoadHandler extends PlainHandler
{

    protected $strict_handler = false;

    public function supports($profile)
    {
        return $profile instanceof Profile;
    }

}
