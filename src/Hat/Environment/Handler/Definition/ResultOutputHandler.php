<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;

use Hat\Environment\State\DefinitionState;
use Hat\Environment\TesterOutput;

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

        if ($definition->getState()->isFail()) {

            echo "[FAIL]  ";
            echo $definition->getDescription();
            echo "\n";
            echo "\n";
            echo "        ";
            echo "definition : ";
            echo $definition->getName();
            echo "\n";

            echo "\n";
            echo "        options : ";
            $this->printHolder($definition->getOptions());
            echo "\n";

            echo "        properties : ";
            $this->printHolder($definition->getProperties());
            echo "\n";

            echo "        command : ";
            $this->printHolder($definition->getCommand());
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


    protected function printHolder($holder)
    {
        echo "\n";

        foreach ($holder as $name => $value) {
            if (!is_null($value)) {
                echo "            ";
                echo (string)$name;
                echo " : ";
                echo (string)new TesterOutput($value);
                echo "\n";
            }
        }

        echo "\n";
    }


}
