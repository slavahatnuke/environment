<?php

namespace Environment;

class Context extends Holder
{
    protected $defaults = array();

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->init();
    }

    public function init()
    {
        $this->extend($this->defaults);
    }

}
