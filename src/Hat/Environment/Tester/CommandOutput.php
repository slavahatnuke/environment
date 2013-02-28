<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;
use Hat\Environment\TesterOutput;


class CommandOutput extends Tester
{
    protected $defaults = array(
        'command' => 'CLI command',
        'regex' => null,
    );

    public function test()
    {
        $command = $this->get('command');
        $output = array();
        exec($command, $output, $return);
        $this->set('output', new TesterOutput($output));

        $output = join("", $output);

        if ($return == 0) {
            return $this->testOutput($output);
        }

        return false;
    }
    
    public function testOutput($output)
    {
        if (false == $this->get('regex')) {
            return false;
        }
        
        return preg_match($this->get('regex'), $output);
    }
}
