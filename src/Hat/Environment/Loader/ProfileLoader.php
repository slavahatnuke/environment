<?php
namespace Hat\Environment\Loader;

use Hat\Environment\Profile;

class ProfileLoader
{
    public function load(Profile $profile){

        $profile->setData($this->read($profile->getPath()));

        if ($profile->has('@import')) {

            if (!is_array($profile->get('@import'))) {
                throw new LoaderException('invalid import: ' . $profile->getPath());
            }

            $imports = $profile->get('@import');

            foreach ($imports as $path) {
                $parent = $this->loadByPath($profile->getFile($path));
                $profile->extend($parent);
                $profile->addParent($parent);
                $profile->set('@import', $imports);
            }

        }

        return $profile;
    }

    public function loadByPath($path){
        return $this->load(new Profile($path));
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
