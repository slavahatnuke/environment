<?php
namespace Hat\Environment\Handler\Profile;

use Hat\Environment\Profile;
use Hat\Environment\Handler\Handler;

use Hat\Environment\Kit\Kit;


class ProfileAutoExtendsHandler extends Handler
{

    /**
     * @var Kit
     */
    protected $kit;

    public function __construct(Kit $kit)
    {
        $this->kit = $kit;
    }

    public function supports($profile)
    {
        return $profile instanceof Profile
            && $profile->hasOwner()
            && $profile->getOwner()->hasParent()
            && (
                !$profile->getSystemDefinitions()->has('extends') ||
                    $profile->getSystemDefinitions()->get('extends')->getValue() == false
            );
    }

    protected function doHandle($profile)
    {
        return $this->handleProfile($profile);
    }

    protected function handleProfile(Profile $profile)
    {


        if ($this->getProfileLoader()->hasForProfile($profile->getOwner()->getParent(), $profile->getPath())) {
            $loaded = $this->getProfileLoader()->loadForProfile($profile->getOwner()->getParent(), $profile->getPath());
            $profile->extend($loaded);
        }


    }

    /**
     * @return \Hat\Environment\Loader\ProfileLoader
     */
    protected function getProfileLoader()
    {
        return $this->kit->get('profile.loader');
    }

}
