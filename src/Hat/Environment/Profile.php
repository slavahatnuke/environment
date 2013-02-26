<?php
namespace Hat\Environment;

class Profile extends Holder
{

    protected $path;

    /**
     * @var Profile
     */
    protected $parents = array();

    protected $system_definitions = array('@import');

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


    public function addParent(Profile $parent)
    {
        $this->parents[] = $parent;
    }

    /**
     * @return Profile
     */
    public function getParents()
    {
        return $this->parents;
    }

    public function hasParents()
    {
        return count($this->parents) ? true : false;
    }

    public function getBasePath()
    {
        return dirname($this->getPath());
    }

    public function hasFile($path)
    {
        $has = $this->hasOwnFile($path);

        if (!$has && $this->hasParents()) {

            foreach ($this->getParents() as $parent) {
                if ($parent->hasFile($path)) {
                    return true;
                }
            }

            return false;
        }

        return $has;
    }

    public function getFile($path)
    {
        if ($this->hasOwnFile($path)) {
            return $this->getOwnFile($path);
        } else {
            if ($this->hasParents()) {

                foreach ($this->getParents() as $parent) {
                    if ($parent->hasFile($path)) {
                        return $parent->getFile($path);
                    }
                }

            }
        }

        throw new \Exception('No file: ' . $this->getOwnFile($path));

    }

    public function getDefinitions()
    {
        $result = array();

        foreach ($this->getData() as $name => $value) {
            if (!in_array($name, $this->system_definitions)) {
                $result[$name] = new Definition($name, $value);
            }
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
