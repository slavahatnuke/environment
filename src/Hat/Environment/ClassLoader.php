<?php
namespace Hat\Environment;

class ClassLoader
{
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
        $this->register();
    }

    public function register()
    {
        spl_autoload_register(array($this, 'load'));
    }

    protected function load($class){


        $class = str_replace('\\', '/', trim($class, '\/'));
        $file = $this->path . '/' . $class . '.php';
        if(file_exists($file))
        {
            require_once $file;
        }


    }
}