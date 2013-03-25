<?php
namespace Hat\Environment\Handler;

use Hat\Environment\Profile;
use Hat\Environment\Handler\PlainHandler;

class ProfileLoaderHandler extends PlainHandler
{

    public function supports($profile)
    {
        return $profile instanceof Profile;
    }

}
