<?php
namespace Hat\Environment\Tester;


use Hat\Environment\TesterOutput;

class CommandExists extends Tester
{
    protected $defaults = array(
        'finder' => 'which'
    );

    public function test()
    {
        //TODO [extract][cli][component] extract to CLI component
        $command = $this->get('command');
        $cmd = $this->get('finder') . ' ' . $command;
        $output = '';
        exec($cmd, $output, $return);

        $this->set('output', new TesterOutput($output));

        return $return == 0;
    }
}
