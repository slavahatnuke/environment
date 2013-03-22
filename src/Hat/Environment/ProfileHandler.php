<?php
namespace Hat\Environment;

class ProfileHandler extends Handler
{
    public function supports($profile)
    {
        return $profile instanceof Profile;
    }

    protected function doHandle($profile)
    {

        $tester = new ProfileTester($profile->getPath());

        return $tester->test();
    }



}
