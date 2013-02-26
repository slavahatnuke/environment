<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;
use Hat\Environment\TesterOutput;


class CommandVersion extends Tester
{
    protected $defaults = array(
        'command' => 'CLI command',
        'version' => 'min version',
        'max_version' => null,
        'regex' => '/(\d+\.\d+\.\d+)/',
    );

    public function test()
    {

        //TODO [extract][cli][component]
        $command = $this->get('command');
        $output = array();
        exec($command, $output, $return);
        $this->set('output', new TesterOutput(join('', $output)));

        $output = join("", $output);

        if ($return == 0) {
            $version = $this->extractVersion($output);

            return $this->testMinVersion($version) && $this->testMaxVersion($version);
        }

        return false;
    }

    public function testMinVersion($version)
    {
        if ($version && $this->get('version')) {
            return version_compare($version, $this->get('version')) >= 0;
        }
    }

    public function testMaxVersion($version)
    {
        if (is_null($this->get('max_version'))) {
            return true;
        }

        if ($version && $this->get('max_version')) {
            return version_compare($version, $this->get('max_version')) <= 0;
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
