<?php
namespace Hat\Environment\Handler;

use Hat\Environment\Definition;

class DefinitionHandler extends PlainHandler
{

    public function supports($definition)
    {
        return $definition instanceof Definition;
    }

    protected function doHandle($definition)
    {
        parent::doHandle($definition);
    }


}
