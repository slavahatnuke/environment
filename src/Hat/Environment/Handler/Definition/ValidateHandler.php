<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\Handler\Handler;
use Hat\Environment\Handler\HandlerException;

class ValidateHandler extends Handler
{
    public function supports($definition)
    {
        return $definition instanceof Definition;
    }


    protected function doHandle($definition)
    {
        if (!$definition->getOptions()->has('class')) {
            throw new HandlerException('Class is not defined for definition: ' . $definition->getName());
        }

    }

}
