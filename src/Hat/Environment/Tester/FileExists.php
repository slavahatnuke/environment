<?php
namespace Hat\Environment\Tester;


use Hat\Environment\LimitedString;

class FileExists extends Tester
{
    protected $defaults = array(
        'file' => 'path to file',
    );

    public function test()
    {
        $file = $this->get('file');

        if (file_exists($file)) {
            return true;
        }
        $this->set('output', new LimitedString('file does not exist: ' . $file));
        return false;
    }
}
