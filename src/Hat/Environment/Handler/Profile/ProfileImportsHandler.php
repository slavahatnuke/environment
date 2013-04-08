<?php
namespace Hat\Environment\Handler\Profile;

use Hat\Environment\Profile;
use Hat\Environment\Handler\Handler;

use Hat\Environment\Kit\Kit;

class ProfileImportsHandler extends Handler
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
        return $profile instanceof Profile && $profile->getSystemDefinitions()->has('@imports');
    }

    protected function doHandle($profile)
    {
        return $this->handleProfile($profile);
    }

    protected function handleProfile(Profile $profile)
    {

        $definition = $profile->getSystemDefinitions()->get('@imports');

        foreach ($definition->getProperties() as $path) {

            $imported = $this->getProfileLoader()->loadForProfile($profile, $path);
            $imported->setOwner($profile);

            $profile->imports($imported);
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
