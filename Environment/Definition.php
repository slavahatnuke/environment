<?php

namespace Environment;

class Definition extends Holder
{
    protected $name;

    protected $option_prefix = '@';

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
        return substr($name, 0, 1) == $this->option_prefix;
    }

    protected function extractOption($name)
    {
        return $this->isOption($name) ? substr($name, 1) : $name;
    }

}
