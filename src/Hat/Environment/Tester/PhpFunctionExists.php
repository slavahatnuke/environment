<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;

class PhpFunctionExists extends Tester
{
    protected $defaults = array(
        'function' => 'function name'
    );

    public function test()
    {
        return function_exists($this->get('function'));
    }
}
