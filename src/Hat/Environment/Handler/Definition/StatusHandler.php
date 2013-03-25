<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\State\State;
use Hat\Environment\State\DefinitionState;

class StatusHandler extends DefinitionHandler
{


    public function supports($definition)
    {
        return $definition instanceof Definition;
    }

    protected function handleDefinition(Definition $definition)
    {
        $state = $definition->getState();
        $options = $definition->getOptions();

        if ($options->has('required') && !$options->get('required') && $state->isState(State::FAIL)) {
            return $state->setState(DefinitionState::SKIP);
        }


//        $skipped = $skipped || (!$passed && !$options->get('required'));
//
//        $failed = !$passed && !$skipped;
//
//        $status = $passed ? "[OK]    " : "[FAIL]  ";
//        $status = $skipped ? "[SKIP]  " : $status;
//
//        $fixed = $passed && $definition->get('@built');

    }

}
