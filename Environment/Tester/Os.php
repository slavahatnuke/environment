<?php
namespace Environment\Tester;

use Environment\Tester;

class Os extends Tester
{
    protected $defaults = array(
        'name' => 'OS name'
    );

    public function test()
    {
        $this_os = strtolower(php_uname());
        $os = strtolower($this->get('name'));

        return strpos($this_os, $os) !== false;
    }
}
