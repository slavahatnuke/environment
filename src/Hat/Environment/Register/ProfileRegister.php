<?php
namespace Hat\Environment\Register;

use Hat\Environment\Holder;
use Hat\Environment\Profile;

use Hat\Environment\Exception;

class ProfileRegister extends Holder
{
    /**
     * @var Profile
     */
    protected $profile;

    public function register(Profile $profile)
    {
        $this->profile = $profile;
        $this->set($profile->getPath(), $profile);
    }

    /**
     * @return Profile|null
     */
    public function getProfile()
    {
        if (!$this->profile) {
            throw new Exception('Profile is not defined');
        }

        return $this->profile;
    }


}
