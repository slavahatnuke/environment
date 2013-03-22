<?php
namespace Hat\Environment\Handler;

use Hat\Environment\Profile;
use Hat\Environment\ProfileTester;

class ProfileHandler extends Handler
{

    /**
     * @var DefinitionHandler
     */
    protected $definition_handler;

    public function __construct(DefinitionHandler $definition_handler)
    {
        $this->definition_handler = $definition_handler;
    }


    public function supports($profile)
    {
        return $profile instanceof Profile;
    }

    protected function doHandle($profile)
    {
        $tester = new ProfileTester($profile->getPath());
        $profile = $tester->getProfile();

        foreach ($profile->getDefinitions() as $definition) {
            $this->definition_handler->handle($definition);
        }

        return $tester->test();
    }


}
