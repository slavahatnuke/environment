<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\Handler\HandlerException;

class ValidateHandler extends DefinitionHandler
{
    public function supports($definition)
    {
        return $definition instanceof Definition
            && !$definition->getOptions()->has('run');
    }

    protected function handleDefinition(Definition $definition)
    {
        if (!$definition->getOptions()->has('class')) {
            throw new HandlerException('Options class is not defined for definition: ' . $definition->getName());
        }

        $class = $definition->getOptions()->get('class');
        if (!class_exists($class)) {
            throw new HandlerException("Class `{$class}` is not found for definition: " . $definition->getName());
        }

    }

}
