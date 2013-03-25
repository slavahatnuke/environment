<?php
namespace Hat\Environment\Handler;

use Hat\Environment\Profile;
use Hat\Environment\Handler\PlainHandler;

class SystemDefinitionHandler extends PlainHandler
{

    public function supports($profile)
    {
        return $profile instanceof Profile;
    }

    protected function doHandle($profile)
    {
        return $this->handleProfile($profile);
    }

    protected function handleProfile(Profile $profile)
    {
    }


}
