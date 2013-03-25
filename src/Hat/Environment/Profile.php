<?php
namespace Hat\Environment;

use Hat\Environment\State\ProfileState;

class Profile
{

    protected $path;

    /**
     * @var \Hat\Environment\State\ProfileState
     */
    protected $state;

    /**
     * @var Profile[]
     */
    protected $parents = array();

    /**
     * @var Definition[]|Holder
     */
    protected $definitions;

    /**
     * @var Definition[]|Holder
     */
    protected $system_definitions;

    public function __construct($path)
    {
        $this->setPath($path);
    }

    /**
     * @var \Hat\Environment\State\DefinitionState
     */
    public function getState()
    {
        if (!$this->state) {
            $this->state = new ProfileState();
        }
        return $this->state;
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

            $parents = array_reverse($this->getParents());

            foreach ($parents as $parent) {
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

                $parents = array_reverse($this->getParents());

                foreach ($parents as $parent) {
                    if ($parent->hasFile($path)) {
                        return $parent->getFile($path);
                    }
                }

            }
        }

        throw new Exception('No file: ' . $this->getOwnFile($path));

    }

    /**
     * @param Definition $definition
     */
    public function addDefinition(Definition $definition)
    {
        $this->getDefinitions()->set($definition->getName(), $definition);
    }

    /**
     * @return Definition[]|Holder
     */
    public function getDefinitions()
    {

        if (!$this->definitions) {
            $this->definitions = new Holder();
        }

        return $this->definitions;


    }

    /**
     * @return Definition[]|Holder
     */
    public function getSystemDefinitions()
    {

        if (!$this->system_definitions) {
            $this->system_definitions = new Holder();
        }

        return $this->system_definitions;
    }

    /**
     * @param Definition $definition
     */
    public function addSystemDefinition(Definition $definition)
    {
        $this->getSystemDefinitions()->set($definition->getName(), $definition);
    }

    protected function getOwnFile($path)
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . $path;
    }

    protected function hasOwnFile($path)
    {
        return file_exists($this->getOwnFile($path));
    }

    public function apply(Profile $profile)
    {

        foreach ($profile->getDefinitions() as $name => $definition) {

            if ($this->getDefinitions()->has($name)) {
                $this->getDefinitions()->get($name)->apply($definition);
            } else {
                $this->addDefinition($definition);
            }

        }

    }

    public function extend(Profile $parent)
    {

        $parent = clone $parent;

        $parent->apply($this);
        $this->apply($parent);

        $this->addParent($parent);

    }


}
