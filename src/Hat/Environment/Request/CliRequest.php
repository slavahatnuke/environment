<?php

namespace Hat\Environment\Request;

class CliRequest extends Request
{

    protected $parameters = array();

    public function __construct($defaults = array())
    {
        parent::__construct($defaults);
        $this->load();
    }

    protected function load()
    {
        $options = isset($_SERVER['argv']) ? $_SERVER['argv'] : array();

        foreach ($options as $option) {
            $this->defineOption($option);
        }

        if (count($this->parameters)) {
            $this->set('parameters', $this->parameters);
        }

    }

    protected function defineOption($option)
    {
        $a = array();

        if (preg_match('/--(.+?)=(.+)/', $option, $a)) {
            return $this->set($a[1], $a[2]);
        }

        if (preg_match('/--(.+)/', $option, $a)) {
            return $this->set($a[1], true);
        }

        $this->parameters[] = $option;
    }
}
