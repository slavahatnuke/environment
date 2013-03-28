<?php
namespace Hat\Environment\Handler\Profile;

use Hat\Environment\Profile;
use Hat\Environment\Handler\Handler;
use Hat\Environment\Loader\LoaderException;

class DefinitionExtendsHandler extends Handler {

    public function supports($profile) {
        return $profile instanceof Profile;
    }

    protected function doHandle($profile) {
        return $this->handleProfile($profile);
    }

    protected function handleProfile(Profile $profile) {

        foreach ($profile->getDefinitions() as $definition) {

            if ($definition->getOptions()->has('extends')) {

                $extends = $definition->getOptions()->get('extends');

                if ($def = $profile->getDefinitions()->get($extends)) {
                    $definition->extend($def);
                } else {
                    throw new LoaderException("Definitions `{$extends}` is not found in profile `{$profile->getPath()}`");
                }
            }


        }

    }

}
