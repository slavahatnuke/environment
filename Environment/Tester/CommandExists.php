<?php
namespace Environment\Tester;

use Environment\Tester;

class CommandExists extends Tester
{
    public function test()
    {
        //TODO [extract][cli][component] extract to CLI component
        $command = $this->get('command');
        $cmd = 'which ' . $command;
        $output = '';
        exec($cmd, $output, $return);

        return $return == 0;
    }
}