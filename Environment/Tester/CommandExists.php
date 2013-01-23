<?php
namespace Environment\Tester;

use Environment\Tester;

class CommandExists extends Tester
{
    public function test(){

        $command = $this->get('command');
        $cmd = 'which ' . $command;
        $output = '';
        exec('which ' . $command, $output, $return);

//        var_dump($return);
        return $return == 0;
    }
}
