<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;

use Hat\Environment\State\DefinitionState;
use Hat\Environment\LimitedString;

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

        if ($definition->getState()->isOk()) {
            $this->handleOk($definition);
        }

        if ($definition->getState()->isFail()) {
            $this->handleFail($definition);
        }

    }

    protected function handleFail(Definition $definition)
    {

        $print_statuses = array(
            DefinitionState::FAIL,
            DefinitionState::NOT_FIXED
        );

        if ($definition->getState()->isState($print_statuses)) {

            if ($definition->getState()->isState(DefinitionState::NOT_FIXED)) {
                $this->output->write(new StatusLineMessage(DefinitionState::FAIL, $definition->getDescription()));
            }

            echo "\n";
            echo "                ";
            echo "definition : ";
            echo $definition->getName();
            echo "\n";
            echo "\n";

            echo "                properties : ";
            $this->printHolder($definition->getProperties());
            echo "\n";

            echo "                options : ";
            $this->printHolder($definition->getOptions());
            echo "\n";

            if ($definition->hasCommand()) {
                echo "                result : ";
                $this->printHolder($definition->getCommand());
                echo "\n";
            }


        } else {
            $this->output->write(new StatusLineMessage(DefinitionState::FAIL, $definition->getDescription()));
        }


    }

    protected function handleOk(Definition $definition)
    {
        if ($definition->getState()->isState(DefinitionState::FIXED)) {
            $this->output->write(new StatusLineMessage(DefinitionState::OK, $definition->getDescription()));
        }
    }


    protected function printHolder($holder)
    {
        echo "\n";

        foreach ($holder as $name => $value) {
            if (!is_null($value)) {
                echo "                  ";
                echo (string)$name;
                echo " : ";
                echo (string)new LimitedString($value);
                echo "\n";
            }
        }

        echo "\n";
    }


}
