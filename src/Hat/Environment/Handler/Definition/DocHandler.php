<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\Handler\Handler;

class DocHandler extends Handler
{

    public function supports($definition)
    {
        return false;
    }

    protected function doHandle($definition)
    {
        return $this->handleDefinition($definition);
    }

    protected function handleDefinition(Definition $definition)
    {

//        //TODO [extract][decompose][handler][definition]
//        if ($failed && $doc = $options->get('doc')) {
//            $this->printDoc($doc);
//        }

    }

}
