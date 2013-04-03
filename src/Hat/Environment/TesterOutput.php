<?php
namespace Hat\Environment;

class TesterOutput
{

    protected $text = '';
    protected $max_length = 100;

    public function __construct($text, $max_length = 80)
    {

        if(is_array($text))
        {
            $text = join('', $text);
        }

        $this->text = (string)$text;
        $this->max_length = $max_length;
    }

    public function __toString()
    {

        if (strlen($this->text) > $this->max_length) {
            return substr($this->text, 0, $this->max_length) . '...';
        }

        return $this->text;
    }

}
