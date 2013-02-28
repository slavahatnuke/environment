<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;
use Hat\Environment\TesterOutput;

/**
 * @author Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class CommandVersionExclude extends Tester
{
    protected $defaults = array(
        'command' => 'CLI command',
        'version' => 'version',
        'regex'   => '/(\d+\.\d+\.\d+)/',
    );

    public function test()
    {
        //TODO [extract][cli][component]
        $command = $this->get('command');
        $output = array();
        exec($command, $output, $return);
        $this->set('output', new TesterOutput($output));

        $output = join('', $output);

        if ($return == 0) {
            $version = $this->extractVersion($output);
            return !$this->testVersion($version);
        }

        return false;
    }

    public function testVersion($version)
    {
        if ($version && $this->get('version')) {
            return version_compare($version, $this->get('version')) == 0;
        }
    }

    public function extractVersion($string)
    {
        $a = array();
        if (preg_match($this->get('regex'), $string, $a)) {
            return $a[1];
        }
    }
}
