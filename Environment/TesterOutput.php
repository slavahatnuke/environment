<?php

namespace Environment;

class TesterOutput
{

    protected $text = ''; 
    protected $max_length = 100;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function __toString(){

        if(strlen($this->text) > $this->max_length)
        {
            return substr($this->text, 0, $this->max_length);
        }

        return $this->text;
    }

}
