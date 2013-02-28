<?php
namespace Hat\Environment;

class Definition extends Context
{
    protected $name;

    protected $optionPrefix = '@';

    protected $placeHolderSeparator = '%%';

    protected $defaults = array(
        '@class' => null,
        '@negative' => false,
        '@required' => true,
        '@test.on.pass' => null,
        '@doc' => null,
        '@description' => null,
        '@built' => null,
        '@passed' => false,
    );

    public function __construct($name, $data = array())
    {
        $this->setName($name);
        parent::__construct($data);
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
        $result = array();

        foreach ($this as $name => $value) {
            if (!$this->isOption($name)) {
                $result[$name] = $value;
            }
        }

        return new Holder($result);
    }

    /**
     * @return Holder
     */
    public function getOptions()
    {
        $result = array();

        foreach ($this as $name => $value) {
            if ($this->isOption($name)) {
                $result[$this->extractOption($name)] = $value;
            }
        }

        return new Holder($result);
    }

    protected function isOption($name)
    {
        return substr($name, 0, 1) == $this->optionPrefix;
    }

    protected function extractOption($name)
    {
        return $this->isOption($name) ? substr($name, 1) : $name;
    }

    public function getDescription()
    {
        if ($description = $this->getOptions()->get('description')) {
            $replace = array();
            foreach ($this->getData() as $key => $val) {
                $key = strtoupper($key);
                $replace["{$this->placeHolderSeparator}{$key}{$this->placeHolderSeparator}"] = $val;
            }
            return str_replace(array_keys($replace), array_values($replace), $description);
        }
        return $this->getName();
    }
}
