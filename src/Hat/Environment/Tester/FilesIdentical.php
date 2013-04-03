<?php
namespace Hat\Environment\Tester;


use Hat\Environment\TesterOutput;
use Hat\Environment\Exception;

class FilesIdentical extends Tester
{
    protected $defaults = array(
        'file' => null,
        'file2' => null,
    );

    public function test()
    {
        $file = $this->get('file');
        $file2 = $this->get('file2');

        if (!($file && $file2)) {
            throw new Exception('options file and file2 must be initialised');
        }

        if (!file_exists($file)) {
            $this->set('output', new TesterOutput('file does not exist: ' . $file));
            return false;
        }
        if (!file_exists($file2)) {
            $this->set('output', new TesterOutput('file2 does not exist: ' . $file2));
            return false;
        }
        if (md5_file($file) == md5_file($file2)) {
            return true;
        }

        $this->set('output', new TesterOutput("files '{$file}' and '{$file2}' are different"));
        return false;
    }
}
