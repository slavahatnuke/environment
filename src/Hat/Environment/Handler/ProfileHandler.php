<?php
namespace Hat\Environment\Handler;

use Hat\Environment\Profile;

use Hat\Environment\Loader\ProfileLoader;
use Hat\Environment\Register\ProfileRegister;

use Hat\Environment\State\State;

use Hat\Environment\Output\Output;
use Hat\Environment\Output\Message\StatusLineMessage;

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

    /**
     * @var Output
     */
    protected $output;

    public function __construct(ProfileLoader $loader, ProfileRegister $register, DefinitionHandler $definition_handler, Output $output)
    {
        $this->loader = $loader;
        $this->definition_handler = $definition_handler;
        $this->register = $register;
        $this->output = $output;
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
        $this->output->write(new StatusLineMessage('handle', $profile->getPath()));

        $profile->getState()->setState(State::OK);

        $failed = 0;
        $passed = 0;
        foreach ($profile->getDefinitions() as $definition) {

            $definition->recompile();
            $this->definition_handler->handle($definition);

            if ($definition->getState()->isFail()) {
                $profile->getState()->setState(State::FAIL);
                $failed++;
            } else if ($definition->getState()->isOk()) {
                $passed++;
            }

        }

        $this->output->write(new StatusLineMessage($profile->getState()->getState(), "passed {$passed}, failed {$failed}"));

    }


}
