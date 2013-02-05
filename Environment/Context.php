<?php

namespace Environment;

class Context extends Holder
{
    protected $defaults = array();

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->initDefaults();
    }

    public function initDefaults()
    {
        $this->extend($this->defaults);
    }

}
