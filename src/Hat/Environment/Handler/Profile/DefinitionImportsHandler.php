<?php
namespace Hat\Environment\Handler\Profile;

use Hat\Environment\Profile;
use Hat\Environment\Handler\Handler;
use Hat\Environment\Loader\LoaderException;

class DefinitionImportsHandler extends Handler
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

        foreach ($profile->getDefinitions() as $definition) {

            if ($definition->getOptions()->has('imports')) {

                $imports = $definition->getOptions()->get('imports');

                if ($def = $profile->getDefinitions()->get($imports)) {
                    $definition->extend($def);
                } else {
                    throw new LoaderException("Definitions `{$imports}` is not found in profile `{$profile->getPath()}`");
                }
            }


        }

    }

}
