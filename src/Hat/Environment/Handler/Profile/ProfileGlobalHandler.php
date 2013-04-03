<?php
namespace Hat\Environment\Handler\Profile;

use Hat\Environment\Profile;
use Hat\Environment\Handler\Handler;

class ProfileGlobalHandler extends Handler
{

    public function supports($profile)
    {
        return $profile instanceof Profile && $profile->getSystemDefinitions()->has('@global');
    }

    protected function doHandle($profile)
    {
        return $this->handleProfile($profile);
    }

    protected function handleProfile(Profile $profile)
    {
        $definition = $profile->getSystemDefinitions()->get('@global');
        //TODO setup globals

    }


}
