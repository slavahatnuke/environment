<?php

namespace Environment;

class Environment
{
    protected $definition_defaults = array(
        'class' => null,
        'required' => true,
        'test.on.pass' => null,
        'doc' => null,
        'confirm' => null,
        'confirm.message' => 'Confirmation of test execution.',
        'confirm.question' => 'Do you confirm this test? (y/n)',
    );

    protected $base_path;

    public function __construct($base_path = '')
    {
        $this->base_path = $base_path;
    }

    public function test($path)
    {
        // TODO [extract][output] remove 'echo "\n"' and extract output to suitable class
        echo "\n";

        foreach ($this->getProfile($path)->getDefinitions() as $definition) {
            $this->testDefinition($definition);
        }

        echo "\n";

    }

    public function testDefinition(Definition $definition)
    {

        //TODO [extract][test][definition] extract testing definition to suitable class
        $options = $definition->getOptions();
        $options->extend($this->definition_defaults);

        if ($class = $options->get('class')) {

            if (class_exists($class)) {

                $tester = new $class;
                $tester->apply($definition->getProperties());

                $passed = false;
                $aborted = false;

                if ($options->get('confirm')) {
                    if ($this->confirm($definition, $tester)) {
                        $passed = $tester->test();
                    } else {
                        $aborted = true;
                    }
                } else {
                    $passed = $tester->test();
                }


                //TODO [output][test][status][state] move to definition state

                $skipped = !$passed && !$options->get('required');

                $failed = !$passed && !$skipped;

                $status = $passed ? "[OK]    " : "[FAIL]  ";
                $status = $skipped ? "[SKIP]  " : $status;
                $status = $aborted ? "[ABORT] " : $status;

                //TODO [output]
                echo $status;

                echo $definition->getName();
                echo "\n";


                //TODO [extract][decompose][handler][definition] decompose to definition handlers
                if ($aborted) {
                    return;
                }

                //TODO [extract][decompose][handler][definition] decompose to definition handlers
                if ($failed) {
                    $this->printHolder($tester);

                    echo "        ";
                    echo "class : ";
                    echo $class;
                    echo "\n";
                    echo "\n";

                }

                //TODO [extract][decompose][handler][definition]
                if ($failed && $doc = $options->get('doc')) {
                    $this->printDoc($doc);
                }

                //TODO [extract][decompose][handler][definition]
                if ($passed && $on_pass = $options->get('test.on.pass')) {
                    $this->test($on_pass);
                }

            } else {
                throw new \Exception('no class:' . $class);
            }
        }

    }

    protected function printDoc($doc)
    {
        echo "\n";
        echo $this->getDoc($doc);
        echo "\n";
        echo "\n";
        echo "\n";
    }

    protected function printHolder($holder)
    {
        echo "\n";

        foreach ($holder as $name => $value) {
            if (!is_null($value)) {
                echo "        ";
                echo $name;
                echo " : ";
                echo $value;
                echo "\n";
            }
        }

        echo "\n";
    }

    public function getProfile($path)
    {
        $profile = new Profile($this->read($this->base_path . $path));

        if ($profile->has('@extends')) {
            $parent = $this->getProfile($profile->get('@extends'));
            $profile->extend($parent);
        }

        return $profile;
    }

    public function getDoc($path)
    {
        // TODO add doc readers
        $doc = $this->base_path . $path;

        if (file_exists($doc)) {
            return file_get_contents($doc);
        } else {
            throw new \Exception('No file: ' . $doc);
            // TODO [exception] handling exceptions
        }

    }

    public function read($path)
    {
        // TODO add readers
        if (file_exists($path)) {
            return parse_ini_file($path, true);
        } else {
            throw new \Exception('No file: ' . $path);
            // TODO [exception]
        }

        return array();

    }

    public function confirm(Definition $definition, Tester $tester)
    {

        $options = $definition->getOptions();
        $options->extend($this->definition_defaults);

        if($options->get('confirm'))
        {

            echo "[TEST]  ";
            echo $definition->getName();
            echo "\n";
            echo "\n";
            echo "        ";
            echo $options->get('confirm.message');
            echo "\n";

            $this->printHolder($tester);
            $this->printHolder($definition);

            echo "\n";
            echo "[ASK]  ";
            echo $options->get('confirm.question');
            echo " ";

            $answer = strtolower(trim(fgets(STDIN)));

            if(in_array($answer, array('y', 'yes')))
            {
                return true;
            }

        }

        return false;
    }

}
