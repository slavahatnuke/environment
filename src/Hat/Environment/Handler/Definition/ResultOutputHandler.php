<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;

use Hat\Environment\State\DefinitionState;
use Hat\Environment\TesterOutput;

use Hat\Environment\Output\Output;
use Hat\Environment\Output\Message\StatusLineMessage;

class ResultOutputHandler extends DefinitionHandler
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


        if ($definition->getState()->isState(DefinitionState::FIXED)) {
            $this->output->write(new StatusLineMessage($definition->getState()->getState(), $definition->getDescription()));
        }

        if ($definition->getState()->isFail()) {

            $this->output->write(new StatusLineMessage(DefinitionState::FAIL, $definition->getDescription()));

            echo "\n";
            echo "          ";
            echo "definition : ";
            echo $definition->getName();
            echo "\n";

            echo "\n";
            echo "          options : ";
            $this->printHolder($definition->getOptions());
            echo "\n";

            echo "          properties : ";
            $this->printHolder($definition->getProperties());
            echo "\n";

            echo "          command : ";
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
