<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\State\State;

use Hat\Environment\Kit\Kit;


class OnPassHandler extends DefinitionHandler
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
            && $definition->getState()->isState(State::OK)
            && $definition->getOptions()->get('on.pass');
    }

    protected function handleDefinition(Definition $definition)
    {
        $path = $definition->getOptions()->get('on.pass');
        $parent_profile = $this->kit->get('profile.register')->getProfile();

        $profile = $this->kit->get('profile.loader')->loadForProfile($parent_profile, $path);

        $this->kit->get('profile.handler')->handle($profile);

        if ($profile->getState()->isState(State::FAIL)) {
            $definition->getState()->setState(State::FAIL);
        }

    }

}
