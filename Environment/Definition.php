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

    public function isValid()
    {
        return true;
    }

    /**
     * @return Holder
     */
    public function getProperties()
    {
        $result = array();

        foreach ($this as $key => $value) {
            if (!$this->isOption($key)) {
                $result[$key] = $value;
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

        foreach ($this as $key => $value) {
            if ($this->isOption($key)) {
                $result[$this->extractOption($key)] = $value;
            }
        }

        return new Holder($result);
    }

    public function isOption($property)
    {
        return substr($property, 0, 1) == $this->option_prefix;
    }

    protected function extractOption($property)
    {
        return $this->isOption($property) ? substr($property, 1) : $property;
    }

}
