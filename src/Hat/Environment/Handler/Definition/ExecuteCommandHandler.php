<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;

use Hat\Environment\Command;
use Hat\Environment\Handler\HandlerException;

use Hat\Environment\Kit\Kit;

use Hat\Environment\State\State;

class ExecuteCommandHandler extends DefinitionHandler
{

    /**
     * @var \Hat\Environment\Kit\Kit
     */
    protected $kit;

    public function __construct(Kit $kit)
    {
        $this->kit = $kit;
    }

    public function supports($definition)
    {
        return $definition instanceof Definition && $definition->getState()->isState(State::INIT);
    }

    protected function handleDefinition(Definition $definition)
    {
        $class = $definition->getOptions()->get('class');

        $command = new $class;

        if ($command instanceof Command) {
            $command->setupServices($this->kit);
            $definition->setCommand($command);
        } else {
            throw new HandlerException("Class in definition `{$definition->getName()}` is not a command");
        }

        $passed = $command();

        $definition->getState()->setState($passed ? State::OK : State::FAIL);

    }

}
