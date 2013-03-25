<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;

use Hat\Environment\State\DefinitionState;

class ResultOutputHandler extends DefinitionHandler
{


    public function supports($definition)
    {
        return $definition instanceof Definition;
    }

    protected function handleDefinition(Definition $definition)
    {


        if ($definition->getState()->isState(DefinitionState::FIXED)) {
            //TODO [output]
            echo "[FIXED] ";

            echo $definition->getDescription();
            echo "\n";

        }

        if ($definition->getState()->isState(DefinitionState::NOT_FIXED)) {
            //TODO [output]
            echo "[NOT FIXED] ";

            echo $definition->getDescription();
            echo "\n";

        }

//
//        //TODO [extract][decompose][handler][definition] decompose to definition handlers
//        if ($failed) {
//            $this->printHolder($tester);
//
//            echo "        ";
//            echo "class : ";
//            echo $class;
//            echo "\n";
//            echo "\n";
//
//        }

    }

}
