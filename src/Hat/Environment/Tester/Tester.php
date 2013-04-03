<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Command;

class Tester extends Command
{
    public function execute()
    {
        return $this->test();
    }


    public function test()
    {
    }

}
