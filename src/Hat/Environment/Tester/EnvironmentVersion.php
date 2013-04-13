<?php
namespace Hat\Environment\Tester;


use Hat\Environment\LimitedString;
use Hat\Environment\Exception;

class EnvironmentVersion extends Tester {

    protected $defaults = array(
        'command' => null,
        'regex' => '/.+/',
        'file' => 'environment.version',
    );

    public function test() {

        if (is_null($this->get('command'))) {
            throw new Exception('EnvironmentVersion: command is required');
        }

        $command = $this->get('command');
        $output = array();
        exec($command, $output, $return);
        $this->set('output', new LimitedString($output));

        $output = join("", $output);

        if ($return == 0) {

            if ($this->testOutputWithRegex($output)) {

                $result = $this->extractOutput($output);

                if (file_exists($this->get('file'))) {

                    $stored = file_get_contents($this->get('file'));

                    if ($stored == $result) {
                        return true;
                    }

                }

                file_put_contents($this->get('file'), $result);
                return false;

            }
        }

        throw new Exception('EnvironmentVersion: can not handle command: ' . $this->get('command'));
    }

    public function extractOutput($output) {
        if (preg_match($this->get('regex'), $output, $a)) {

            if (isset($a[1])) {
                return $a[1];
            }

            return $a[0];
        }
    }

    public function testOutputWithRegex($output) {
        if (is_null($this->get('regex'))) {

            return false;
        }

        return preg_match($this->get('regex'), $output);
    }


    public function testContains($output) {

        if (is_null($this->get('contains'))) {
            return false;
        }

        return strpos(strtolower($output), strtolower($this->get('contains'))) !== false;
    }

}
