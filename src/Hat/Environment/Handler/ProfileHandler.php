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

    /**
     * @var \Hat\Environment\Register\ProfileRegister
     */
    protected $register;

    public function __construct(DefinitionHandler $definition_handler, $loader, $register)
    {
        $this->loader = $loader;
        $this->definition_handler = $definition_handler;
        $this->register = $register;
    }


    public function handlePath($path)
    {
        return $this->handle($this->loader->loadByPath($path));
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
    {
        $this->register->register($profile);
        $this->handleDefinitions($profile);
    }

    protected function handleDefinitions(Profile $profile)
    {
        echo "\n";
        echo "[handle] ";
        echo $profile->getPath();
        echo "\n";
        echo "\n";

        $profile->getState()->setState(State::OK);

        foreach ($profile->getDefinitions() as $definition) {

            $this->definition_handler->handle($definition);

            if ($definition->getState()->isFail()) {
                $profile->getState()->setState(State::FAIL);
            }

        }
        
        echo "[{$profile->getState()->getState()}] tests";
        echo "\n";
        echo "\n";

    }


}
