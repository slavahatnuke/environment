<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;

use Hat\Environment\State\State;

use Hat\Environment\State\DefinitionState;

class StatusLineOutputHandler extends DefinitionHandler
{


    public function supports($definition)
    {
        return $definition instanceof Definition;
    }

    protected function handleDefinition(Definition $definition)
    {

        $state = $definition->getState();

        if ($state->isState(DefinitionState::FIXED)) {
            //TODO [output]
            echo "[FIXED] ";

            echo $definition->getDescription();
            echo "\n";

        }


        //TODO [output]
        echo "[{$state->getState()}] ";

        echo $definition->getDescription();
        echo "\n";


    }

}
