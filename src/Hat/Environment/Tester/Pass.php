<?php
namespace Hat\Environment\Tester;


use Hat\Environment\LimitedString;

class Pass extends Tester
{
    public function test()
    {
        return true;
    }
}
