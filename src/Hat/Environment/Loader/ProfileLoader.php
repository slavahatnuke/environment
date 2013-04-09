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

    public function __construct(Handler $postLoadHandler, Output $output, ProfileBuilder $builder)
    {
        $this->postLoadHandler = $postLoadHandler;
        $this->output = $output;
        $this->builder = $builder;
    }


    /**
     * @param \Hat\Environment\Profile $profile
     * @return \Hat\Environment\Profile
     * @throws LoaderException
     */
    public function load(Profile $profile)
    {

        $path = $this->findPath($profile);

        $this->output->write(new StatusLineMessage(ProfileState::LOAD, $path));

        $this->builder->build($profile, $this->read($path));
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
        $loaded = new Profile($path);
        $loaded->setOwner($profile);

        return $this->load($loaded);
    }

    public function loadDocForProfile(Profile $profile, $path)
    {
        $path = $this->findPathForProfile($profile, $path);

        $this->output->write(new StatusLineMessage('doc', $path));

        return file_get_contents($path);
    }

    protected function findPath(Profile $profile)
    {
        $path = $this->getPath($profile);

        if (file_exists($path)) {
            return $path;
        }

        if ($profile->hasOwner()) {
            return $this->findPathForProfile($profile->getOwner(), $profile->getPath());
        }

        if ($profile->hasParent()) {
            return $this->findPathForProfile($profile->getParent(), $profile->getPath());
        }

        throw new LoaderException('Path is not found: ' . $profile->getPath());
    }

    protected function findPathForProfile(Profile $profile, $path)
    {

        $file = $this->getBasePath($profile) . DIRECTORY_SEPARATOR . $path;

        if (file_exists($file)) {
            return $file;
        }

        if ($profile->hasOwner()) {

            $file = $this->findPathForProfile($profile->getOwner(), $path);

            if (!is_null($file)) {
                return $file;
            }

        }

        if ($profile->hasParent()) {

            $file = $this->findPathForProfile($profile->getParent(), $path);

            if (!is_null($file)) {
                return $file;
            }

        }


    }

    protected function getPath(Profile $profile)
    {
        if ($profile->hasOwner()) {
            return $this->getBasePath($profile->getOwner()) . DIRECTORY_SEPARATOR . $profile->getPath();
        }

        return $profile->getPath();
    }

    protected function getBasePath($profile)
    {
        return dirname($this->getPath($profile));
    }


    protected function read($path)
    {
        //TODO add readers
        if (file_exists($path)) {
            return parse_ini_file($path, true);
        } else {
            throw new LoaderException('File is not found: ' . getcwd() . DIRECTORY_SEPARATOR . $path);
        }

        return array();

    }


}
