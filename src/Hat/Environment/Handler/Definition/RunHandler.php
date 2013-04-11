<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\State\State;

use Hat\Environment\Kit\Kit;

use Hat\Environment\State\DefinitionState;
use Hat\Environment\Output\Message\StatusLineMessage;

class RunHandler extends DefinitionHandler
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
            && $definition->getState()->isState(State::INIT)
            && $definition->getOptions()->get('run');
    }

    protected function handleDefinition(Definition $definition)
    {

        $definition->getState()->setState(State::OK);

        $path = $definition->getOptions()->get('run');


        $this->kit->get('output')->write(new StatusLineMessage(State::OK, $definition->getDescription()));
        $this->kit->get('output')->write(new StatusLineMessage('run', $path));

        $current_profile = $this->kit->get('profile.register')->getProfile();

        $profile = $this->kit->get('profile.loader')->loadForProfile($current_profile, $path);

        $this->kit->get('profile.handler')->handle($profile);

        if ($profile->getState()->isFail()) {
            $definition->getState()->setState(DefinitionState::FAIL);
        }

        if ($profile->getState()->isOk()) {
            $definition->getState()->setState(DefinitionState::OK);
        }

        $this->kit->get('profile.register')->register($current_profile);

    }

}
