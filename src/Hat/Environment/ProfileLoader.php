<?php
namespace Hat\Environment;

class ProfileLoader
{
    public function load($path){
        return new Profile($path);
    }

    public function loadProfile(Profile $profile){

        return $profile;
    }

}
