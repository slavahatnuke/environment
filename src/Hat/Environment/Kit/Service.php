<?php
namespace Hat\Environment\Kit;

class Service
{
    /**
     * @var Closure
     */
    protected $closure;

    public function __construct($closure)
    {
        $this->closure = $closure;
    }

    public function __invoke(Kit $kit)
    {
        $closure = $this->closure;
        return is_callable($closure) ? $closure($kit) : null;
    }


}
