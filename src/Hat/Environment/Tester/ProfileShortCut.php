<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;
use Hat\Environment\Request\CliRequest;

class ProfileShortCut extends Tester
{
    protected $defaults = array(
        'name' => null
    );

    public function test()
    {

        $request = new CliRequest();
        if ($this->has('name') && $request->has($this->get('name'))) {
            return true;
        }
        return false;
    }
}
