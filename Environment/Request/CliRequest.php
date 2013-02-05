<?php

namespace Environment\Request;

use Environment\Request;

class CliRequest extends Request
{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->load();
    }

    protected function load()
    {
        $env = isset($_SERVER['argv']) ? $_SERVER['argv'] : array();

        foreach ($env as $option) {
            $this->defineOption($option);
        }
    }

    protected function defineOption($option)
    {
        $a = array();

        if (preg_match('/--(.+?)=(.+)/', $option, $a)) {
            $this->set($a[1], $a[2]);
        } else if (preg_match('/--(.+)/', $option, $a)) {
            $this->set($a[1], true);
        }

    }

}
