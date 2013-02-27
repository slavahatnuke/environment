<?php
namespace Hat\Environment;

class ProfileTester extends Tester
{

    /**
     * @var Profile
     */
    protected $profile;

    protected $path;

    protected $status;

    public function __construct($path)
    {
        $this->setPath($path);
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }


    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function getProfile()
    {
        if (!$this->profile) {
            $this->profile = $this->load($this->path);
        }

        return $this->profile;
    }

    public function testChild($path)
    {
        $tester = new ProfileTester($this->getProfile()->getFile($path));

        return $tester->test();
    }

    public function test()
    {

        // TODO [extract][output] remove 'echo "\n"' and extract output to suitable class
        echo "\n";
        echo "[TEST]  ";
        echo $this->getPath();
        echo "\n";
        echo "\n";

        $definitions = $this->getProfile()->getDefinitions();

        $status = true;
        ;

        foreach ($definitions as $definition) {
            if (!$this->testDefinition($definition) && $status) {
                $status = false;
            }

        }

        echo "\n";

        return $status;

    }

    public function testDefinition(Definition $definition)
    {

        //TODO [extract][test][definition] extract testing definition to suitable class
        $options = $definition->getOptions();

        $class = $options->get('class');

        if ($class) {

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
                    $failed = !$this->testChild($on_pass);
                }

                return !$failed;

            } else {
                throw new \Exception('no class:' . $class);
            }
        } else {
            throw new \Exception('no class for definition: ' . $definition->getName());
        }

        return true;

    }

    protected function printDoc($doc)
    {
        echo "\n";
        echo $this->readDoc($doc);
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
                echo (string)$name;
                echo " : ";
                echo (string)$value;
                echo "\n";
            }
        }

        echo "\n";
    }

    protected function readDoc($path)
    {
        return file_get_contents($this->getProfile()->getFile($path));
    }

    /**
     * @param $path
     * @return Profile
     */
    protected function load($path)
    {

        $profile = new Profile($path);
        $profile->setData($this->read($profile->getPath()));

        if ($profile->has('@import')) {

            if (!is_array($profile->get('@import'))) {
                throw new \Exception('invalid import: ' . $path);
            }

            $import_pathes = $profile->get('@import');

            foreach ($import_pathes as $import_path) {
                $parent = $this->load($profile->getFile($import_path));
                $profile->extend($parent);
                $profile->addParent($parent);
                $profile->set('@import', $import_pathes);
            }

        }


        return $profile;
    }

    protected function read($path)
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
