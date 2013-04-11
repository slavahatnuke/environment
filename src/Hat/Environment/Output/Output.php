<?php
namespace Hat\Environment\Output;

use Hat\Environment\State\DefinitionState;

class Output
{
    public function write($message = '')
    {
        echo (string)$message;
    }

    public function writeln($message = '')
    {
        $this->write($message);
        $this->write("\n");
    }

    public function flush()
    {

    }
}
