<?php
namespace Environment\Tester;

use Environment\Tester;

class ProcessListenPort extends Tester
{
    protected $defaults = array(
        'command' => 'sudo netstat -natp',
        'process' => 'process name',
        'port' => null
    );

    public function test()
    {

        //TODO [extract][cli][component]
        $command = $this->get('command');
        $output = array();
        exec($command, $output, $return);

        if ($return == 0) {

            foreach ($output as $line) {
                if ($this->containsprocess($line) && $this->containsPort($line)) {
                    return true;
                }
            }

        }


        return false;
    }

    protected function containsprocess($line)
    {
        return !is_null($this->get('process')) && strpos($line, $this->get('process')) !== false;
    }


    protected function containsPort($line)
    {
        return !is_null($this->get('port')) && strpos($line, $this->get('port')) !== false;
    }


}
