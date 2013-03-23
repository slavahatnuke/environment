<?php
namespace Hat\Environment\Handler;

use Hat\Environment\Profile;
use Hat\Environment\ProfileTester;

use Hat\Environment\State\State;

class ProfileHandler extends Handler
{

    /**
     * @var DefinitionHandler
     */
    protected $definition_handler;

    /**
     * @var \Hat\Environment\Loader\ProfileLoader
     */
    protected $loader;

    public function __construct(DefinitionHandler $definition_handler, $loader)
    {
        $this->loader = $loader;
        $this->definition_handler = $definition_handler;
    }


    public function supports($profile)
    {
        return $profile instanceof Profile;
    }

    protected function doHandle($profile)
    {
        return $this->handleProfile($profile);
    }

    protected function handleProfile(Profile $profile)
    { // TODO [extract][output] remove 'echo "\n"' and extract output to suitable class
        echo "\n";
        echo "[TEST]  ";
        echo $profile->getPath();
        echo "\n";
        echo "\n";

        $profile->getState()->setState(State::OK);

        foreach ($profile->getDefinitions() as $definition) {
            $this->definition_handler->handle($definition);
        }

        $tester = new ProfileTester($profile, $this->loader);

        return $tester->test();
    }


}
