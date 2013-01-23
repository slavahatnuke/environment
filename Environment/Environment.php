<?php

namespace Environment;

class Environment
{
    protected $definition_defaults = array(
        'class' => null,
        'required' => true,
        'test.on.pass' => null
    );

    protected $base_path;

    public function __construct($base_path = '')
    {
        $this->base_path = $base_path;
    }

    public function test($path)
    {
        echo "\n";

        foreach ($this->getProfile($path)->getDefinitions() as $definition) {
            $this->testDefinition($definition);
        }

        echo "\n";

    }

    public function testDefinition(Definition $definition)
    {

        $options = $definition->getOptions();
        $options->extend($this->definition_defaults);

        if ($class = $options->get('class')) {

            if (class_exists($class)) {

                $tester = new $class;
                $tester->apply($definition->getProperties());

                $passed = $tester->test();

                $status = $passed ? "[OK]   " : "[FAIL] ";
                $status = !$passed && !$options->get('required') ? "[SKIP] " : $status;

                echo $status;

                echo $definition->getName();
                echo "\n";

                if(!$passed && $doc = $options->get('doc'))
                {
                    echo "\n";
                    echo $this->getDoc($doc);
                    echo "\n";
                    echo "\n";
                }

                if($passed && $on_pass = $options->get('test.on.pass'))
                {
                    $this->test($on_pass);
                }

            } else {
                throw new \Exception('no class:' . $class);
            }
        }

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

        if(file_exists($doc))
        {
            return file_get_contents($doc);
        } else {
            throw new \Exception('No file: ' . $doc);
            // TODO Exception
        }

    }

    public function read($path)
    {
        // TODO add readers
        if (file_exists($path)) {
            return parse_ini_file($path, true);
        } else {
            throw new \Exception('No file: ' . $path);
            // TODO Exception
        }

        return array();

    }


}
