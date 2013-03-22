<?php
namespace Hat\Environment;

class ProfileLoader
{
    public function load(Profile $profile){
        return $profile;
    }

    public function loadByPath($path){
        return new Profile($path);
    }

}
