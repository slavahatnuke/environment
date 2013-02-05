<?php
namespace Environment\Tester;

use Environment\Tester;
use Environment\TesterOutput;

class CommandExists extends Tester
{
    public function test()
    {
        //TODO [extract][cli][component] extract to CLI component
        $command = $this->get('command');
        $cmd = 'which ' . $command;
        $output = '';
        exec($cmd, $output, $return);

        $this->set('output', new TesterOutput(join('', $output)));

        return $return == 0;
    }
}
