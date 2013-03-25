<?php
namespace Hat\Environment;

use Hat\Environment\State\DefinitionState;

class Definition extends Context
{
    protected $name;

    protected $optionPrefix = '@';

    protected $placeHolderSeparator = '%%';

    protected $defaults = array(
        '@class' => null,
        '@negative' => false,
        '@required' => true,
        '@on.pass' => null,
        '@doc' => null,
        '@description' => null,
        '@built' => null,
        '@passed' => false,
        '@recompile' => true,
    );

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


    public function __construct($name, $data = array())
    {
        $this->setName($name);
        parent::__construct($data);
        $this->recompile();
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


    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Holder
     */
    public function getProperties()
    {
        if (!$this->properties) {

            $result = array();

            foreach ($this as $name => $value) {
                if (!$this->isOption($name)) {
                    $result[$name] = $value;
                }
            }

            $this->properties = new Holder($result);
        }

        return $this->properties;
    }

    /**
     * @return Holder
     */
    public function getOptions()
    {
        if (!$this->options) {

            $result = array();

            foreach ($this as $name => $value) {
                if ($this->isOption($name)) {
                    $result[$this->extractOption($name)] = $value;
                }
            }

            $this->options = new Holder($result);

        }

        return $this->options;

    }

    public function recompile()
    {
        if ($this->getOptions()->get('recompile')) {


            foreach ($this->getOptions() as $key => $value) {
                $this->getOptions()->set($key, $this->compileText($value, $this->getProperties()));
            }

            foreach ($this->getProperties() as $key => $value) {
                $this->getProperties()->set($key, $this->compileText($value, $this->getProperties()));
            }

        }
    }

    public function getDescription()
    {
        if ($description = $this->getOptions()->get('description')) {
            return $this->compileText($description);
        }
        return $this->getName();
    }

    protected function isOption($name)
    {
        return substr($name, 0, 1) == $this->optionPrefix;
    }

    protected function extractOption($name)
    {
        return $this->isOption($name) ? substr($name, 1) : $name;
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
