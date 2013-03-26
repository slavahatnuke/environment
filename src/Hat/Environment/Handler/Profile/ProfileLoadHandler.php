<?php
namespace Hat\Environment\Handler\Profile;

use Hat\Environment\Profile;
use Hat\Environment\Handler\PlainHandler;

class ProfileLoadHandler extends PlainHandler
{

    protected $strict_handler = false;

    public function supports($profile)
    {
        return $profile instanceof Profile;
    }

}
