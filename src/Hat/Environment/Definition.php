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
        '@recompile' => true,
    );

    public function __construct($name, $data = array())
    {
        $this->setName($name);
        parent::__construct($data);
        $this->recompile();
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


    protected function recompile()
    {
        if($this->getOptions()->get('recompile'))
        {
            foreach($this as $key => $value)
            {
                 $this->set($key, $this->compileText($value));
            }
        }
    }
    protected function compileText($text)
    {
        $replace = array();
        foreach ($this as $key => $val) {
            $key = strtoupper($key);
            $key = "{$this->placeHolderSeparator}{$key}{$this->placeHolderSeparator}";
            $replace[$key] = $val;
        }
        return strtr($text, $replace);
    }

    public function getDescription()
    {
        if ($description = $this->getOptions()->get('description')) {
            return $this->compileText($description);
        }
        return $this->getName();
    }
}
