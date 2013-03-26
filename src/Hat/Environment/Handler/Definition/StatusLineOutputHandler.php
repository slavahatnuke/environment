<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;

use Hat\Environment\State\State;

use Hat\Environment\State\DefinitionState;

use Hat\Environment\Output\Output;
use Hat\Environment\Output\Message\StatusLineMessage;

class StatusLineOutputHandler extends DefinitionHandler
{


    /**
     * @var Output
     */
    protected $output;

    public function __construct(Output $output)
    {
        $this->output = $output;
    }


    public function supports($definition)
    {
        return $definition instanceof Definition;
    }

    protected function handleDefinition(Definition $definition)
    {
        $this->output->write(new StatusLineMessage($definition->getState()->getState(), $definition->getDescription()));
    }

}
