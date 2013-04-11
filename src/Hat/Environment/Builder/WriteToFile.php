<?php
namespace Hat\Environment\Builder;


use Hat\Environment\TesterOutput;

class WriteToFile extends Builder
{
    protected $defaults = array(
        'file' => null,
        'content' => null,
    );

    public function build()
    {
        if (!$this->get('file')) {
            throw new \Exception("Paramater 'file' must not be null");
        }
        if (false === file_put_contents($this->get('file'), $this->get('content'))) {
            return false;
        }
        return true;
    }
}
