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
     * @var Profile
     */
    protected $owner;

    /**
     * @var Profile
     */
    protected $parent;

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

    /**
     * @param \Hat\Environment\Profile $owner
     */
    public function setOwner(Profile $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return \Hat\Environment\Profile
     */
    public function getOwner()
    {
        if (!$this->hasOwner()) {
            throw new Exception('Owner is not defined');
        }

        return $this->owner;
    }

    /**
     * @return bool
     */
    public function hasOwner()
    {
        return $this->owner ? true : false;
    }

    /**
     * @param \Hat\Environment\Profile $parent
     */
    public function setParent(Profile $parent)
    {
        $this->parent = $parent;
        $this->parents[] = $parent;
    }

    /**
     * @return \Hat\Environment\Profile
     */
    public function getParent()
    {
        if (!$this->hasParent()) {
            throw new Exception('Parent is not defined');
        }

        return $this->parent;
    }

    /**
     * @return bool
     */
    public function hasParent()
    {
        return $this->parent ? true : false;
    }

    /**
     * @return array|\Hat\Environment\Profile[]
     */
    public function getParents()
    {
        return $this->parents;
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

    public function apply(Profile $profile)
    {

        foreach ($profile->getDefinitions() as $definition) {

            if ($this->getDefinitions()->has($definition->getName())) {
                $this->getDefinitions()->get($definition->getName())->apply($definition);
            } else {
                $this->addDefinition($definition);
            }

        }

        foreach ($profile->getSystemDefinitions() as $definition) {

            if ($this->getSystemDefinitions()->has($definition->getName())) {
                $this->getSystemDefinitions()->get($definition->getName())->apply($definition);
            } else {
                $this->addSystemDefinition($definition);
            }

        }

    }

    public function imports(Profile $profile)
    {
        return $this->apply($profile);
    }

    public function extend(Profile $parent)
    {

        $result = new self('.');

        $result->apply($parent);
        $result->apply($this);

        $this->definitions = null;
        $this->system_definitions = null;

        $this->apply($result);

        $this->setParent($parent);

    }


}
