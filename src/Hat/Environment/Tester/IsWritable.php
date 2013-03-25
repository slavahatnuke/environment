<?php
namespace Hat\Environment\Tester;



class IsWritable extends Tester
{
    protected $defaults = array(
        'path' => 'path to file or dir'
    );

    public function test()
    {
        return is_writable($this->get('path'));
    }
}
