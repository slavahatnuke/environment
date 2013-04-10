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

        $this->loadRealProfile($profile);

        $this->postLoadHandler->handle($profile);

        $this->loadVirtualProfile($profile);

        if (!$this->has($profile)) {
            throw new LoaderException('Profile is not found: ' . $profile->getPath());
        }

        return $profile;
    }


    protected function loadVirtualProfile(Profile $profile)
    {
        if (!$this->has($profile)) {

            // find profile
            $this->output->write(new StatusLineMessage('find', $this->getPath($profile)));
            $this->output->write(new StatusLineMessage('find profile', $profile->getPath()));

            // find profile by owner parent
            if ($profile->hasOwner() && $profile->getOwner()->hasParent() && $this->hasForProfile($profile->getOwner()->getParent(), $profile->getPath())) {

                $parent = $this->loadForProfile($profile->getOwner()->getParent(), $profile->getPath());
                $this->output->write(new StatusLineMessage('create profile', $this->getPath($profile)));

                $profile->extend($parent);

                return $profile;
            }

            // find profile by owner
            if ($profile->hasOwner() && $profile->getOwner()->hasOwner() && $this->hasForProfile($profile->getOwner()->getOwner(), $profile->getPath())) {

                $parent = $this->loadForProfile($profile->getOwner()->getOwner(), $profile->getPath());
                $this->output->write(new StatusLineMessage('create profile', $this->getPath($profile)));

                $profile->extend($parent);

                return $profile;
            }

        }

    }

    protected function loadRealProfile($profile)
    {
        $path = $this->getPath($profile);

        if ($this->reader->has($path)) {

            $this->output->write(new StatusLineMessage(ProfileState::LOAD, $path));

            $data = $this->reader->read($path);
            $this->builder->build($profile, $data);

        }
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

        return 'DOC...';
//        $docProfile = $this->loadForProfile($profile, $path);
//
//        if ($docProfile = $this->findReal($docProfile)) {
//
//            $docPath = $this->getPath($docProfile);
//
//            $this->output->write(new StatusLineMessage('doc', $docPath));
//
//            //TODO move to reader too
//            return file_get_contents($docPath);
//        }

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

    protected function fixPath($path)
    {
        $s = '\\' . preg_quote(DIRECTORY_SEPARATOR);
        $path = preg_replace("/[^{$s}]+{$s}\.\.{$s}/", '', $path);
        $path = trim($path, '.' . DIRECTORY_SEPARATOR);

        return $path;
    }

    protected function getBasePath(Profile $profile)
    {
        return dirname($this->getPath($profile));
    }


}
