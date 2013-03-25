<?php
namespace Hat\Environment\Loader;

use Hat\Environment\Profile;
use Hat\Environment\Definition;

class ProfileLoader
{

    protected $definitionOptionPrefix = '@';

    protected $systemDefinitionPrefix = '@';


    /**
     * @param \Hat\Environment\Profile $profile
     * @return \Hat\Environment\Profile
     * @throws LoaderException
     */
    public function load(Profile $profile)
    {

        $data = $this->read($profile->getPath());

        foreach ($data as $name => $value) {

            $definition = $this->createDefinition($name, $value);

            if ($this->isSystemDefinition($name)) {
                $profile->addSystemDefinition($definition);
            } else {
                $profile->addDefinition($definition);
            }
        }

        return $profile;
    }

    /**
     * @param $path
     * @return \Hat\Environment\Profile
     */
    public function loadByPath($path)
    {
        return $this->load(new Profile($path));
    }

    /**
     * @param \Hat\Environment\Profile $profile
     * @param $path
     * @return \Hat\Environment\Profile
     */
    public function loadForProfile(Profile $profile, $path)
    {
        $child = $this->loadByPath($profile->getFile($path));
        $child->addParent($profile);
        return $child;
    }

    public function loadDocForProfile(Profile $profile, $path)
    {
        $path = $profile->getFile($path);
        return file_get_contents($path);
    }


    /**
     * @param $name
     * @param $data
     * @return \Hat\Environment\Definition
     */
    protected function createDefinition($name, $data)
    {
        $definition = new Definition($name);

        if (is_array($data)) {
            $this->defineOptions($definition, $data);
            $this->defineProperties($definition, $data);
        } else {
            $definition->setValue($data);
        }

        $definition->recompile();

        return $definition;
    }

    protected function handleSystemDefinition(Profile $profile, $name, $data)
    {
        if ($name == '@import') {

            if (!is_array($data)) {
                throw new LoaderException('invalid import: ' . $profile->getPath());
            }

            $imports = $data;

            foreach ($imports as $path) {

                $parent = $this->loadForProfile($profile, $path);
                $profile->addParent($parent);

                foreach ($parent->getDefinitions() as $definition) {
                    $profile->addDefinition($definition);
                }

            }

        }

    }

    protected function read($path)
    {
        // TODO add readers
        if (file_exists($path)) {
            return parse_ini_file($path, true);
        } else {
            throw new LoaderException('File is not found: ' . getcwd() . '/' . $path);
        }

        return array();

    }


    protected function isSystemDefinition($name)
    {
        return substr($name, 0, 1) == $this->systemDefinitionPrefix;
    }

    protected function isOption($name)
    {
        return substr($name, 0, 1) == $this->definitionOptionPrefix;
    }

    protected function extractOption($name)
    {
        return $this->isOption($name) ? substr($name, 1) : $name;
    }


    protected function defineOptions(Definition $definition, $definition_data)
    {

        foreach ($definition_data as $name => $value) {
            if ($this->isOption($name)) {
                $definition->getOptions()->set($this->extractOption($name), $value);
            }
        }

    }

    protected function defineProperties(Definition $definition, $definition_data)
    {
        foreach ($definition_data as $name => $value) {
            if (!$this->isOption($name)) {
                $definition->getProperties()->set($this->extractOption($name), $value);
            }
        }
    }


}
