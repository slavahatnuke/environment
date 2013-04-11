<?php
namespace Hat\Environment\Tester;


use Hat\Environment\LimitedString;

class Fail extends Tester
{
    public function test()
    {
        return false;
    }
}
