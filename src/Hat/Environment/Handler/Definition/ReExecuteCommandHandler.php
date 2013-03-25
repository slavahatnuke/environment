<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\State\State;

use Hat\Environment\Kit\Kit;

use Hat\Environment\State\DefinitionState;

class ReExecuteCommandHandler extends DefinitionHandler
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
            && $definition->hasCommand()
            && $definition->getState()->isState(array(
                DefinitionState::ON_PASS_OK,
                DefinitionState::ON_FAIL_OK,
            ));
    }

    protected function handleDefinition(Definition $definition)
    {
        $command = $definition->getCommand();

        $result = $command();

        if ($result) {
            $definition->getState()->setState(DefinitionState::FIXED);
        } else {
            $definition->getState()->setState(DefinitionState::NOT_FIXED);
        }

    }

}
