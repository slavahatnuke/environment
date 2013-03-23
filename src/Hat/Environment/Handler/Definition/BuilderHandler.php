<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;


class BuilderHandler extends DefinitionHandler
{


    public function supports($definition)
    {
        return false;
    }

    protected function handleDefinition(Definition $definition)
    {

//        if ($failed && $options->get('builder') && !$definition->get('@built')) {
//            if (!$this->build($definition)) {
//                echo "[FAIL]  ";
//                echo $definition->getDescription();
//                echo "\n";
//                echo "\n";
//                echo "        ";
//                echo "definition : ";
//                echo $definition->getName();
//                echo "\n";
//
//                return false;
//            }
//            return true;
//        }
//
//        //TODO [extract][decompose][handler][definition]
//        if ($passed && $options->get('build.on.pass') && !$definition->get('@built')) {
//
//            $failed = !$this->build($definition);
//
//            if ($failed) {
//                echo "[FAIL]  ";
//                echo $definition->getDescription();
//                echo "\n";
//                echo "\n";
//                echo "        ";
//                echo "definition : ";
//                echo $definition->getName();
//                echo "\n";
//                return false;
//            }
//
//            return true;
//        }

    }

}
