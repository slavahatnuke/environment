<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;


class DependsHandler extends DefinitionHandler
{


    public function supports($definition)
    {
        return false;
    }

    protected function handleDefinition(Definition $definition)
    {

//        $skipped = false;
//
//        if ($depends = $definition->getOptions()->get('depends')) {
//            $depends = explode(',', trim($depends));
//
//            foreach ($depends as $depend_definition_name) {
//                if ($this->definitions->has($depend_definition_name)) {
//                    if (!$this->definitions->get($depend_definition_name)->get('@passed')) {
//                        $skipped = true;
//                        break;
//                    }
//                    ;
//                }
//            }
//
//        }

    }

}
