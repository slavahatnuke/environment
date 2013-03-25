<?php
namespace Hat\Environment\Tester;


use Hat\Environment\TesterOutput;

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
        $this->set('output', new TesterOutput('file does not exist: ' . $file));
        return false;
    }
}
