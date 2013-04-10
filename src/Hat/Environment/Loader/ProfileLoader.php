<?php
namespace Hat\Environment\Loader;

use Hat\Environment\Profile;
use Hat\Environment\Handler\Handler;

use Hat\Environment\Output\Output;
use Hat\Environment\Output\Message\StatusLineMessage;
use Hat\Environment\State\ProfileState;
use Hat\Environment\Reader\Reader;

class ProfileLoader
{
    /**
     * @var \Hat\Environment\Handler\Handler
     */
    protected $postLoadHandler;

    /**
     * @var Output
     */
    protected $output;

    /**
     * @var ProfileBuilder
     */
    protected $builder;


    /**
     * @var \Hat\Environment\Reader\Reader
     */
    protected $reader;

    public function __construct(Handler $postLoadHandler, Output $output, ProfileBuilder $builder, Reader $reader)
    {
        $this->postLoadHandler = $postLoadHandler;
        $this->output = $output;
        $this->builder = $builder;
        $this->reader = $reader;
    }

    public function has(Profile $profile)
    {
        $file = $this->getPath($profile);
        return $this->reader->has($file) || ($profile->hasParent() && $this->has($profile->getParent()));
    }

    public function hasForProfile(Profile $profile, $path)
    {
        $file = $this->getBasePath($profile) . DIRECTORY_SEPARATOR . $path;
        return $this->reader->has($file) || ($profile->hasParent() && $this->hasForProfile($profile->getParent(), $path));
    }

    /**
     * @param \Hat\Environment\Profile $profile
     * @return \Hat\Environment\Profile
     * @throws LoaderException
     */
    public function load(Profile $profile)
    {

        $profile->getState()->setState(ProfileState::LOAD);

        $path = $this->getPath($profile);
        $this->output->write(new StatusLineMessage($profile->getState()->getState(), $path));

        if ($this->reader->has($path)) {

            $data = $this->reader->read($path);
            $this->builder->build($profile, $data);

        } else {

            if ($profile->hasOwner() && $profile->getOwner()->hasParent()) {
                $parent = $this->loadForProfile($profile->getOwner()->getParent(), $profile->getPath());
                $profile->extend($parent);
            }

            if ($profile->hasParent()) {
                $parent = $this->loadForProfile($profile->getParent(), $profile->getPath());
                $profile->extend($parent);
            }

        }

        $this->postLoadHandler->handle($profile);

        $profile->getState()->setState(ProfileState::LOADED);

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
        $loaded = new Profile($path);
        $loaded->setOwner($profile);

        return $this->load($loaded);
    }

    public function loadDocForProfile(Profile $profile, $path)
    {
        $docProfile = $this->loadForProfile($profile, $path);

        $docPath = $this->getPath($docProfile);

        if ($this->reader->has($docPath)) {

            $this->output->write(new StatusLineMessage('doc', $path));

            //TODO move to reader too
            return file_get_contents($path);

        }

    }

    protected function getPath(Profile $profile)
    {
        if ($profile->hasOwner()) {
            return $this->getBasePath($profile->getOwner()) . DIRECTORY_SEPARATOR . $profile->getPath();
        }

        return $profile->getPath();
    }

    protected function getBasePath(Profile $profile)
    {
        return dirname($this->getPath($profile));
    }


}
