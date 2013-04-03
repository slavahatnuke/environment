<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;

class RecompileHandler extends DefinitionHandler {


    public function supports($definition) {
        return $definition instanceof Definition;
    }

    protected function handleDefinition(Definition $definition) {

        $definition->recompile();

    }

}
