<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;
use Hat\Environment\TesterOutput;

class Fail extends Tester
{
    public function test()
    {
        return false;
    }
}
