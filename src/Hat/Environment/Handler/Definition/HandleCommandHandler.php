<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\Handler\Handler;

use Hat\Environment\Command;
use Hat\Environment\Handler\HandlerException;

use Hat\Environment\Kit\Kit;


class HandleCommandHandler extends Handler
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
        return $definition instanceof Definition && $definition->getOptions()->has('class');
    }


    protected function doHandle($definition)
    {
        $this->handleDefinition($definition);
    }

    protected function handleDefinition(Definition $definition)
    {
        $class = $definition->getOptions()->get('class');

        $command = new $class;

        if ($command instanceof Command) {
            $command->setupProperties($definition->getProperties());
            $command->setupServices($this->kit);
        } else {
            throw new HandlerException("class in definition `{$definition->getName()}` is not a command");
        }

        $command();
    }

}
