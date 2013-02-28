<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;
use Hat\Environment\TesterOutput;

class Process extends Tester
{
    protected $defaults = array(
        'process' => 'process name',
        'command' => 'ps -ef',
    );

    public function test()
    {

        //TODO [extract][cli][component]
        $command = $this->get('command');
        $output = array();
        exec($command, $output, $return);

        $this->set('output', new TesterOutput($output));

        if ($return == 0) {

            foreach ($output as $line) {
                if ($this->containsProcess($line)) {
                    return true;
                }
            }

        }

        return false;
    }

    protected function containsProcess($line)
    {
        return !is_null($this->get('process')) && strpos($line, $this->get('process')) !== false;
    }

}
