<?php
namespace Hat\Environment\Output\Message;

use Hat\Environment\State\DefinitionState;

class Message
{
    public function render()
    {
        return '';
    }

    public function __toString()
    {
        return $this->render();
    }

}
