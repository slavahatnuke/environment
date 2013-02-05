<?php

namespace Environment;

class Profile extends Holder
{

    protected $path;

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

    public function getBasePath()
    {
        return dirname($this->getPath());
    }

    public function getDefinitions()
    {
        $result = array();

        foreach ($this->getData() as $name => $value) {
            $result[$name] = new Definition($name, $value);

        }

        return $result;
    }

}
