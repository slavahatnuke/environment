<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\State\State;

use Hat\Environment\State\DefinitionState;

use Hat\Environment\Kit\Kit;
use Hat\Environment\Output\Message\StatusLineMessage;

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

        $this->kit->get('output')->write(new StatusLineMessage('on.fail', $path));

        $current_profile = $this->kit->get('profile.register')->getProfile();

        $profile = $this->kit->get('profile.loader')->loadForProfile($current_profile, $path);

        $this->kit->get('profile.handler')->handle($profile);

        if ($profile->getState()->isFail()) {
            $definition->getState()->setState(DefinitionState::ON_FAIL_FAIL);
        }

        if ($profile->getState()->isOk()) {
            $definition->getState()->setState(DefinitionState::ON_FAIL_OK);
        }


        $this->kit->get('profile.register')->register($current_profile);

    }

}
