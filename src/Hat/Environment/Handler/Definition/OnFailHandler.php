<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\State\State;

use Hat\Environment\Kit\Kit;

class OnFailHandler extends DefinitionHandler
{


    /**
     * @var Kit
     */
    protected $kit;

    public function __construct(Kit $kit)
    {
        $this->kit = $kit;
    }

    public function supports($definition)
    {
        return $definition instanceof Definition
            && $definition->getState()->isState(State::FAIL)
            && $definition->getOptions()->get('on.fail');
    }

    protected function handleDefinition(Definition $definition)
    {
        $path = $definition->getOptions()->get('on.fail');
        $parent_profile = $this->kit->get('profile.register')->getProfile();

        $profile = $this->kit->get('profile.loader')->loadForProfile($parent_profile, $path);

        $this->kit->get('profile.handler')->handle($profile);
    }

}
