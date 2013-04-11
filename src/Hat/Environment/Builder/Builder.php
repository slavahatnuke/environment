<?php
namespace Hat\Environment\Builder;

use Hat\Environment\Command;

class Builder extends Command
{

    public function execute()
    {
        return $this->build();
    }

    public function build()
    {
    }

}
