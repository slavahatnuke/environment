<?php
namespace Hat\Environment\Loader;

use Hat\Environment\Profile;
use Hat\Environment\Definition;

use Hat\Environment\Handler\Handler;

use Hat\Environment\Output\Output;
use Hat\Environment\Output\Message\StatusLineMessage;
use Hat\Environment\State\ProfileState;

class ProfileLoader
{
    protected $definitionOptionPrefix = '@';

    protected $systemDefinitionPrefix = '@';

    /**
     * @var \Hat\Environment\Handler\Handler
     */
    protected $postLoadHandler;

    /**
     * @var Output
     */
    protected $output;

    public function __construct(Handler $postLoadHandler, Output $output)
    {
        $this->postLoadHandler = $postLoadHandler;
        $this->output = $output;
    }


    /**
     * @param \Hat\Environment\Profile $profile
     * @return \Hat\Environment\Profile
     * @throws LoaderException
     */
    public function load(Profile $profile)
    {

        $path = $this->getRealPathForProfile($profile);

        $this->output->write(new StatusLineMessage(ProfileState::LOAD, $path));

        $data = $this->read($path);

        foreach ($data as $name => $value) {

            $definition = $this->createDefinition($name, $value);

            if ($this->isSystemDefinition($name)) {
                $profile->addSystemDefinition($definition);
            } else {
                $profile->addDefinition($definition);
            }
        }

        $this->postLoadHandler->handle($profile);

        return $profile;
    }

    /**
     * @param $path
     * @return \Hat\Environment\Profile
     */
    public function loadByPath($path)
    {
        return $this->load(new Profile($path));
    }

    /**
     * @param \Hat\Environment\Profile $profile
     * @param $path
     * @return \Hat\Environment\Profile
     */
    public function loadForProfile(Profile $profile, $path)
    {
        $loadedProfile = new Profile($path);
        $loadedProfile->setOwner($profile);

        return $this->load($loadedProfile);
    }

    public function loadDocForProfile(Profile $profile, $path)
    {
        $path = $this->getProfileFile($profile, $path);

        $this->output->write(new StatusLineMessage('doc', $path));

        return file_get_contents($path);
    }

    protected function getRealPathForProfile($profile)
    {
        if (!$profile->hasOwner()) {
            return $profile->getPath();
        } else {
            return $this->getProfileFile($profile->getOwner(), $profile->getPath());
        }
    }

    protected function getProfileFilePath(Profile $profile, $path)
    {
        $base = dirname($this->getRealPathForProfile($profile));

        $ownFile = $base . DIRECTORY_SEPARATOR . $path;

        if (file_exists($ownFile)) {
            return $ownFile;
        } else if ($profile->hasOwner()) {
            $owner = $profile->getOwner();
        } else if ($profile->hasParent()) {

            $parent = $profile->getParent();
            $parentFile = $this->getProfileFilePath($parent, $path);

            if (!is_null($parentFile) && file_exists($parentFile)) {
                return $parentFile;
            }

        }
    }

    protected function getProfileFile(Profile $profile, $path)
    {
        $file = $this->getProfileFilePath($profile, $path);

        if (is_null($file)) {
            throw new LoaderException('File is not found: ' . $path);
        }

        return $file;

    }


    /**
     * @param $name
     * @param $data
     * @return \Hat\Environment\Definition
     */
    protected function createDefinition($name, $data)
    {
        $definition = new Definition($name);

        if (is_array($data)) {
            $this->defineOptions($definition, $data);
            $this->defineProperties($definition, $data);
        } else {
            $definition->setValue($data);
        }

        return $definition;
    }

    protected function read($path)
    {
        // TODO add readers
        if (file_exists($path)) {
            return parse_ini_file($path, true);
        } else {
            throw new LoaderException('File is not found: ' . getcwd() . '/' . $path);
        }

        return array();

    }


    protected function isSystemDefinition($name)
    {
        return substr($name, 0, 1) == $this->systemDefinitionPrefix;
    }

    protected function isOption($name)
    {
        return substr($name, 0, 1) == $this->definitionOptionPrefix;
    }

    protected function extractOption($name)
    {
        return $this->isOption($name) ? substr($name, 1) : $name;
    }


    protected function defineOptions(Definition $definition, $definition_data)
    {

        foreach ($definition_data as $name => $value) {
            if ($this->isOption($name)) {
                $definition->getOptions()->set($this->extractOption($name), $value);
            }
        }

    }

    protected function defineProperties(Definition $definition, $definition_data)
    {
        foreach ($definition_data as $name => $value) {
            if (!$this->isOption($name)) {
                $definition->getProperties()->set($this->extractOption($name), $value);
            }
        }
    }


}
