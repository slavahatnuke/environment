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

    protected $definitions;


    public function __construct($path)
    {
        $this->setPath($path);
        $this->definitions = new Holder();
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

            $this->definitions->set($definition->getName(), $definition);

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

                // depends

                $skipped = false;

                if ($depends = $definition->getOptions()->get('depends')) {
                    $depends = explode(',', trim($depends));

                    foreach ($depends as $depend_definition_name) {
                        if($this->definitions->has($depend_definition_name)) {
                            if(!$this->definitions->get($depend_definition_name)->get('@passed')) {
                                $skipped = true;
                                break;
                            };
                        }
                    }

                }

                if ($skipped) {
                    $passed = false;
                } else {
                    $passed = $tester->execute();

                    if ($options->get('negative')) {
                      $passed = !$passed;
                    }
                }


                //TODO [output][test][status][state] move to definition state

                $skipped = $skipped || ( !$passed && !$options->get('required') );

                $failed = !$passed && !$skipped;

                $status = $passed ? "[OK]    " : "[FAIL]  ";
                $status = $skipped ? "[SKIP]  " : $status;

                $fixed = $passed && $definition->get('@built');

                if($fixed) {
                    //TODO [output]
                    echo "[FIXED] ";

                    echo $definition->getDescription();
                    echo "\n";

                }



                //TODO [output]
                echo $status;

                echo $definition->getDescription();
                echo "\n";

                // builders
                if ($failed && $options->get('builder') && !$definition->get('@built')) {
                    if(!$this->build($definition)) {
                        echo "[FAIL]  ";
                        echo $definition->getDescription();
                        echo "\n";
                        echo "\n";
                        echo "        ";
                        echo "definition : ";
                        echo $definition->getName();
                        echo "\n";

                        return false;
                    }
                    return true;
                }

                //TODO [extract][decompose][handler][definition]
                if ($passed && $options->get('build.on.pass') && !$definition->get('@built')) {

                    $failed = !$this->build($definition);

                    if($failed) {
                        echo "[FAIL]  ";
                        echo $definition->getDescription();
                        echo "\n";
                        echo "\n";
                        echo "        ";
                        echo "definition : ";
                        echo $definition->getName();
                        echo "\n";
                        return false;
                    }

                    return true;
                }

                // info about failing
                //TODO [extract][decompose][handler][definition]
                if ($failed) {
                    echo "\n";
                    echo "        ";
                    echo "definition : ";

                    echo $definition->getName();
                    echo "\n";
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
                    $failed = !$this->testChild($on_pass);
                }

                $definition->set('@passed', $passed);

                return !$failed;

            } else {
                throw new Exception('no class:' . $class);
            }
        } else {
            throw new Exception('no class for definition: ' . $definition->getName());
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
                throw new Exception('invalid import: ' . $path);
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
            throw new Exception('No file: ' . getcwd() . '/' . $path);
            // TODO [exception]
        }

        return array();

    }

    protected function build(Definition $testDefinition)
    {

        if ($testDefinition->getOptions()->get('build.on.pass')) {
            $profilePath = $testDefinition->getOptions()->get('build.on.pass');
        } else {
            $profilePath = $testDefinition->getOptions()->get('builder');
        }

        $profilePath = $this->getProfile()->getFile($profilePath);
        $profile = $this->load($profilePath);


        foreach ($profile->getDefinitions() as $definition) {
            if (!$this->buildDefinition($definition)) {
                $testDefinition->set('@built', false);
                return false;
            }
        }

        $testDefinition->set('@built', true);

        return $this->testDefinition($testDefinition);
    }

    protected function buildDefinition(Definition $definition)
    {

        //TODO [extract][test][definition] extract testing definition to suitable class
        $options = $definition->getOptions();

        $class = $options->get('class');

        if ($class) {

            if (class_exists($class)) {

                $builder = new $class;
                $builder->apply($definition->getProperties());

                //TODO [output]
                echo "[BUILD] ";
                echo $definition->getDescription();
                echo "\n";

                $passed = $builder->execute();

                $failed = !$passed;


                echo "\n";

                //TODO [extract][decompose][handler][definition]
                if ($failed) {
                    echo "\n";
                    echo "        ";
                    echo "definition : ";

                    echo $definition->getName();
                    echo "\n";
                }


                //TODO [extract][decompose][handler][definition] decompose to definition handlers
                if ($failed) {
                    $this->printHolder($builder);

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

                return $passed;

            } else {
                throw new Exception('no class:' . $class);
            }
        } else {
            throw new Exception('no class for definition: ' . $definition->getName());
        }

        return true;

    }

}
