<?php
namespace Hat\Environment;

use Hat\Environment\State\DefinitionState;

class Definition
{
    protected $name;

    protected $placeHolderSeparator = '%%';

    protected $options; // system variables

    protected $properties; // command variables

    /**
     * @var \Hat\Environment\State\DefinitionState
     */
    protected $state;

    /**
     * @var Command
     */
    protected $command;


    public function __construct($name)
    {
        $this->setName($name);
    }

    public function setName($name)
    {
        $this->getOptions()->set('name', $name);
    }

    public function getName()
    {
        return $this->getOptions()->get('name');
    }

    public function setValue($value)
    {
        $this->getOptions()->set('value', $value);
    }

    public function getValue()
    {
        return $this->getOptions()->get('value');
    }

    /**
     * @param Command $command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
        $this->command->setupProperties($this->getProperties());
    }

    /**
     * @return bool
     */
    public function hasCommand()
    {
        return $this->command ? true : false;
    }

    /**
     * @return Command
     */
    public function getCommand()
    {

        if (!$this->hasCommand()) {
            throw new Exception('Command is not defined');
        }

        return $this->command;
    }

    /**
     * @var \Hat\Environment\State\DefinitionState
     */
    public function getState()
    {
        if (!$this->state) {
            $this->state = new DefinitionState();
        }
        return $this->state;
    }

    /**
     * @return Holder
     */
    public function getProperties()
    {
        if (!$this->properties) {
            $this->properties = new Holder();
        }
        return $this->properties;
    }

    /**
     * @return Holder
     */
    public function getOptions()
    {
        if (!$this->options) {
            $this->options = new Holder();
        }

        return $this->options;

    }

    public function recompile()
    {
        foreach ($this->getOptions() as $key => $value) {
            $this->getOptions()->set($key, $this->compileText($value, $this->getProperties()));
        }

        foreach ($this->getProperties() as $key => $value) {
            $this->getProperties()->set($key, $this->compileText($value, $this->getProperties()));
        }
    }

    public function getDescription()
    {
        if ($description = $this->getOptions()->get('description')) {
            return $this->compileText($description);
        }
        return $this->getName();
    }

    public function apply(Definition $definition)
    {
        $this->getOptions()->apply($definition->getOptions());
        $this->getProperties()->apply($definition->getProperties());
    }

    protected function compileText($text, $hash = null)
    {
        $hash = $hash ? $hash : $this;

        $replace = array();

        foreach ($hash as $key => $val) {
            $key = strtoupper($key);
            $key = "{$this->placeHolderSeparator}{$key}{$this->placeHolderSeparator}";
            $replace[$key] = $val;
        }

        return strtr($text, $replace);
    }
}
