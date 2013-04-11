<?php
namespace Hat\Environment\Tester;


use Hat\Environment\LimitedString;

class Os extends Tester
{
    protected $defaults = array(
        'name' => 'OS name'
    );

    public function test()
    {
        $this_os = strtolower(php_uname());
        $os = strtolower($this->get('name'));

        $this->set('output', new LimitedString($this_os));

        return strpos($this_os, $os) !== false;
    }
}
