<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;
use Hat\Environment\TesterOutput;

class Pass extends Tester
{
    public function test()
    {
        return true;
    }
}
