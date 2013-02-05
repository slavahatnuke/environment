<?php

namespace Environment;

class Profile extends Holder
{

    protected $path;

    /**
     * @var Profile
     */
    protected $parent;

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


    public function setParent(Profile $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Profile
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function hasParent()
    {
        return $this->parent ? true : false;
    }

    public function getBasePath()
    {
        return dirname($this->getPath());
    }

    public function hasFile($path)
    {
        $has = $this->hasOwnFile($path);

        if (!$has && $this->hasParent()) {
            return $this->getParent()->hasFile($path);
        }

        return $has;
    }

    public function getFile($path)
    {
        if ($this->hasOwnFile($path)) {
            return $this->getOwnFile($path);
        } else if ($this->hasParent()) {
            return $this->getParent()->getFile($path);
        } else {
            throw new \Exception('No file: ' . $this->getOwnFile($path));
        }
    }

    public function getDefinitions()
    {
        $result = array();

        foreach ($this->getData() as $name => $value) {
            $result[$name] = new Definition($name, $value);

        }

        return $result;
    }

    protected function getOwnFile($path)
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . $path;
    }

    protected function hasOwnFile($path)
    {
        return file_exists($this->getOwnFile($path));
    }


}
