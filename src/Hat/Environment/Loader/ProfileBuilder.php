<?php
namespace Hat\Environment\Loader;

use Hat\Environment\Profile;
use Hat\Environment\Definition;

class ProfileBuilder
{
    protected $systemPrefix = '@';

    public function build(Profile $profile, $data)
    {
        foreach ($data as $name => $value) {

            $definition = $this->createDefinition($name, $value);

            if ($this->isSystem($name)) {
                $name = $this->extractName($definition->getName());
                $definition->setName($name);
                $profile->addSystemDefinition($definition);
            } else {
                $profile->addDefinition($definition);
            }
        }
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

        return $definition;
    }

    protected function isSystem($name)
    {
        return substr($name, 0, 1) == $this->systemPrefix;
    }

    protected function extractName($name)
    {
        return $this->isSystem($name) ? substr($name, 1) : $name;
    }

    protected function defineOptions(Definition $definition, $data)
    {

        foreach ($data as $name => $value) {
            if ($this->isSystem($name)) {
                $definition->getOptions()->set($this->extractName($name), $value);
            }
        }

    }

    protected function defineProperties(Definition $definition, $data)
    {
        foreach ($data as $name => $value) {
            if (!$this->isSystem($name)) {
                $definition->getProperties()->set($this->extractName($name), $value);
            }
        }
    }


}
