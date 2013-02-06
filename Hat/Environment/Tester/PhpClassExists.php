<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;

class PhpClassExists extends Tester
{
    protected $defaults = array(
        'class' => 'class name'
    );

    public function test()
    {
        return class_exists($this->get('class'));
    }
}
