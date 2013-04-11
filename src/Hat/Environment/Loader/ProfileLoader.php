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
    protected $handler;

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

    public function __construct(Handler $handler, Output $output, ProfileBuilder $builder, Reader $reader)
    {
        $this->handler = $handler;
        $this->output = $output;
        $this->builder = $builder;
        $this->reader = $reader;
    }

    public function hasReal(Profile $profile)
    {
        return $this->reader->has($this->getPath($profile));
    }


    public function hasForProfileReal(Profile $profile, $path)
    {
        $file = $this->fixPath($this->getBasePath($profile) . DIRECTORY_SEPARATOR . $path);
        return $this->reader->has($file);
    }

    public function hasForProfile(Profile $profile, $path)
    {
        return $this->hasForProfileReal($profile, $path)
            || ($profile->hasParent() && $this->hasForProfile($profile->getParent(), $path));
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
     * @return \Hat\Environment\Profile
     * @throws LoaderException
     */
    public function load(Profile $profile)
    {

        $profile->getState()->setState(ProfileState::LOAD);

        if ($this->hasReal($profile)) {

            $path = $this->getPath($profile);

            $this->output->write(new StatusLineMessage(ProfileState::LOAD, $path));

            $this->builder->build($profile, $this->reader->read($path));

            $this->handler->handle($profile);

        } else {
            throw new LoaderException('Profile is not found: ' . $this->getPath($profile));
        }

        return $profile;
    }


    /**
     * @param \Hat\Environment\Profile $profile
     * @param $path
     * @return \Hat\Environment\Profile
     */
    public function loadForProfile(Profile $profile, $path)
    {

        $this->output->write(new StatusLineMessage(ProfileState::FIND, $this->getPathForProfile($profile, $path)));

        if ($this->hasForProfileReal($profile, $path)) {

            $loaded = new Profile($path);
            $loaded->setOwner($profile);

            return $this->load($loaded);

        } else if ($profile->hasParent() && $this->hasForProfile($profile->getParent(), $path)) {
            return $this->loadForProfile($profile->getParent(), $path);
        }

        throw new LoaderException('Profile is not found: ' . $this->getPathForProfile($profile, $path));

    }

    public function findFileForProfile(Profile $profile, $path)
    {
        if ($this->hasForProfileReal($profile, $path)) {
            return $this->getPathForProfile($profile, $path);
        } else if ($profile->hasParent() && $this->hasForProfile($profile->getParent(), $path)) {
            return $this->findFileForProfile($profile->getParent(), $path);
        }

    }


    public function loadDocForProfile(Profile $profile, $path)
    {

        if (!$this->hasForProfile($profile, $path)) {
            throw new LoaderException('Doc is not found: ' . $this->getPathForProfile($profile, $path));
        }

        return file_get_contents($this->findFileForProfile($profile, $path));
    }

    protected function getPath(Profile $profile)
    {
        if ($profile->hasOwner()) {
            return $this->getPathForProfile($profile->getOwner(), $profile->getPath());
        }

        return $profile->getPath();
    }

    protected function getPathForProfile(Profile $profile, $path)
    {
        return $this->fixPath($this->getBasePath($profile) . DIRECTORY_SEPARATOR . $path);
    }

    protected function getBasePath(Profile $profile)
    {
        return dirname($this->getPath($profile));
    }

    protected function fixPath($path)
    {
        $s = '\\' . preg_quote(DIRECTORY_SEPARATOR);
        $path = preg_replace("/[^{$s}]+{$s}\.\.{$s}/", '', $path);
        $path = trim($path, '.' . DIRECTORY_SEPARATOR);

        return $path;
    }


}
