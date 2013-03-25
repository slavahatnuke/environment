<?php
namespace Hat\Environment\Tester;


use Hat\Environment\TesterOutput;


class CommandOutput extends Tester
{
    protected $defaults = array(
        'command' => 'CLI command',
        'regex' => null,
        'contains' => null,
    );

    public function test()
    {
        $command = $this->get('command');
        $output = array();
        exec($command, $output, $return);
        $this->set('output', new TesterOutput($output));

        $output = join("", $output);

        if ($return == 0) {
            return $this->testOutputWithRegex($output) || $this->testContains($output);
        }

        return false;
    }
    
    public function testOutputWithRegex($output)
    {
        if (is_null($this->get('regex'))) {
            return false;
        }
        
        return preg_match($this->get('regex'), $output);
    }


    public function testContains($output)
    {

        if (is_null($this->get('contains'))) {
            return false;
        }

        return strpos(strtolower($output), strtolower($this->get('contains'))) !== false;
    }

}
