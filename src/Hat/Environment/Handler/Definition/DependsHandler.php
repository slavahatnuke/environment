<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\Kit\Kit;
use Hat\Environment\State\DefinitionState;

use Hat\Environment\Exception;

class DependsHandler extends DefinitionHandler {

    /**
     * @var \Hat\Environment\Kit\Kit
     */
    protected $kit;

    public function __construct(Kit $kit) {
        $this->kit = $kit;
    }


    public function supports($definition) {
        return $definition instanceof Definition && $definition->getOptions()->has('depends');
    }

    protected function handleDefinition(Definition $definition) {

        $depends = $definition->getOptions()->get('depends');
        $depends = explode(',', $depends);

        $profile = $this->getProfile();

        $skipped = false;

        foreach ($depends as $name) {

            if ($def = $profile->getDefinitions()->get($name)) {
                if ($def->getState()->isFail()) {
                    $skipped = true;
                    break;
                }
            } else {
                throw new Exception("Definitions `{$name}` is not found in profile `{$profile->getPath()}`");
            }
        }

        if ($skipped) {
            $definition->getState()->setState(DefinitionState::SKIP);
        }

    }

    /**
     * @return \Hat\Environment\Profile
     */
    protected function getProfile() {
        return $this->kit->get('profile.register')->getProfile();
    }

}
