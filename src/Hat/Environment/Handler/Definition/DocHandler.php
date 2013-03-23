<?php
namespace Hat\Environment\Handler\Definition;

use Hat\Environment\Definition;
use Hat\Environment\Handler\Handler;

use Hat\Environment\State\State;
use Hat\Environment\Kit\Kit;

class DocHandler extends Handler
{

    /**
     * @var Kit
     */
    protected $kit;

    public function __construct(Kit $kit)
    {
        $this->kit = $kit;
    }

    public function supports($definition)
    {
        return $definition instanceof Definition && $definition->getOptions()->has('doc');
    }

    protected function doHandle($definition)
    {
        return $this->handleDefinition($definition);
    }

    protected function handleDefinition(Definition $definition)
    {

        if($definition->getState()->isState(State::FAIL))
        {
            $path = $definition->getOptions()->get('doc');

            $profile = $this->kit->get('profile.register')->getProfile();

            echo $this->kit->get('profile.loader')->loadDocForProfile($profile, $path);
        }

    }

}
