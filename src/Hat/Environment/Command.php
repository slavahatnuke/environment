<?php
namespace Hat\Environment;

use Hat\Environment\Kit\Kit;

class Command extends Context
{

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
