<?php

namespace Environment;

class Environment
{

    public function __invoke(Request $request)
    {
        return $this->handle($request);
    }

    public function handle(Request $request)
    {
        if(!$request->has('profile'))
        {
            throw new \Exception('--profile option is required');
        }

        if(!file_exists($request->get('profile')))
        {
            throw new \Exception('no file: ' . $request->get('profile'));
        }

        $this->test($request->get('profile'));
    }

    public function test($path)
    {
        // TODO [extract][output] remove 'echo "\n"' and extract output to suitable class
        echo "\n";

        $profile = $this->getProfile($path);
        foreach ($profile->getDefinitions() as $definition) {
            $this->testDefinition($profile, $definition);
        }

        echo "\n";

    }

    public function testDefinition(Profile $profile, Definition $definition)
    {

        //TODO [extract][test][definition] extract testing definition to suitable class
        $options = $definition->getOptions();

        if ($class = $options->get('class')) {

            if (class_exists($class)) {

                $tester = new $class;
                $tester->apply($definition->getProperties());


                $passed = $tester->test();

                //TODO [output][test][status][state] move to definition state

                $skipped = !$passed && !$options->get('required');

                $failed = !$passed && !$skipped;

                $status = $passed ? "[OK]    " : "[FAIL]  ";
                $status = $skipped ? "[SKIP]  " : $status;

                //TODO [output]
                echo $status;

                echo $definition->getName();
                echo "\n";


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
                    var_dump($profile->getBasePath(). '/' . $on_pass);
                    $this->test($profile->getBasePath(). '/' . $on_pass);
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
        $profile = new Profile($path);
        $data = $this->readFile($profile->getPath());
        $profile->setData($data);

        if ($profile->has('@extends')) {
            $parent = $this->getProfile($profile->getBasePath() . '/' . $profile->get('@extends'));
            $profile->extend($parent);
            $profile->set('@parent', $parent);
        }

        return $profile;
    }

    public function getDoc($path)
    {
        // TODO add doc readers
        $doc = $path;

        if (file_exists($doc)) {
            return file_get_contents($doc);
        } else {
            throw new \Exception('No file: ' . $doc);
            // TODO [exception] handling exceptions
        }

    }

    public function readFile($path)
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

}
