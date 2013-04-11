<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\Handler\Handler;
use Hat\Environment\State\State;

class NegativeHandler extends Handler
{

    public function supports($definition)
    {
        return $definition->getOptions()->get('negative') == true;
    }

    protected function doHandle($definition)
    {
        return $this->handleDefinition($definition);
    }

    protected function handleDefinition(Definition $definition)
    {
        $state = $definition->getState();

        if ($state->isState(State::OK)) {
            $state->setState(State::FAIL);
        } else if ($state->isState(State::FAIL)) {
            $state->setState(State::OK);
        }

    }

}
