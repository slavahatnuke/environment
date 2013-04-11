<?php
namespace Hat\Environment;

use Hat\Environment\Kit\Kit;

class Command extends Holder
{
    protected $defaults = array();

    public function __construct($data = array())
    {
        $this->apply($this->defaults);
        parent::__construct(array_merge($this->getData(), $data));
    }

    public function setupServices(Kit $kit)
    {

    }

    public function setupProperties($properties)
    {
        $this->apply($properties);
    }


    public function execute()
    {
    }

    public function __invoke()
    {
        return $this->execute();
    }


}
