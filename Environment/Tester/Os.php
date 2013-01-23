<?php
namespace Environment\Tester;

use Environment\Tester;

class Os extends Tester
{
    public function test(){

//        var_dump($this);
        return strtolower(PHP_OS) == strtolower($this->get('name'));
//        var_dump(php_uname());
//        var_dump(PHP_OS);
    }
}
