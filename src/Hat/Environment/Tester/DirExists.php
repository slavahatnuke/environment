<?php
namespace Hat\Environment\Tester;

use Hat\Environment\Tester;
use Hat\Environment\TesterOutput;

class DirExists extends Tester
{
    protected $defaults = array(
        'dir' => 'path to file',
    );

    public function test()
    {
        $file = $this->get('dir');

        if (is_dir($file)) {
            return true;
        }
        $this->set('output', new TesterOutput('dir does not exist: ' . $file));
        return false;
    }
}
