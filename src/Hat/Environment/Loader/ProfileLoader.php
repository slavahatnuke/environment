<?php
namespace Hat\Environment\Loader;

use Hat\Environment\Profile;

class ProfileLoader
{
    /**
     * @param \Hat\Environment\Profile $profile
     * @return \Hat\Environment\Profile
     * @throws LoaderException
     */
    public function load(Profile $profile)
    {

        $profile->setData($this->read($profile->getPath()));

        if ($profile->has('@import')) {

            if (!is_array($profile->get('@import'))) {
                throw new LoaderException('invalid import: ' . $profile->getPath());
            }

            $imports = $profile->get('@import');

            foreach ($imports as $path) {

                $parent = $this->loadByPath($profile->getFile($path));
                $profile->addParent($parent);

                $profile->extend($parent);
                $profile->set('@import', $imports);
            }

        }

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
        $child = $this->loadByPath($profile->getFile($path));
        $child->addParent($profile);
        return $child;
    }


    protected function read($path)
    {
        // TODO add readers
        if (file_exists($path)) {
            return parse_ini_file($path, true);
        } else {
            throw new LoaderException('No file: ' . getcwd() . '/' . $path);
        }

        return array();

    }


}
