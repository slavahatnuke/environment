<?php
namespace Environment\Tester;

use Environment\Tester;

class Os extends Tester
{
    protected $defaults = array(
        'name' => 'os name'
    );

    public function test()
    {
        return strpos(strtolower(php_uname()), strtolower($this->get('name'))) !== false;
    }
}
