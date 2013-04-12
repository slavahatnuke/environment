<?php
namespace Hat\Environment\Tester;


use Hat\Environment\LimitedString;

class PhpGlobalServer extends Tester
{
    protected $defaults = array(
        'key' => null,
        'value' => null,
        'regex' => null,
    );

    public function test()
    {

        if (!$this->hasKey()) {
            $this->set('output', 'Key is not found');
            return false;
        }

        $result = true;
        $this->set('output', $_SERVER[$this->get('key')]);

        if (!is_null($this->get('value')) || !is_null($this->get('regex'))) {
            $result = $this->hasValue() || $this->testValueWithRegex();
        }

        return $result;
    }


    public function hasKey()
    {
        return !is_null($this->get('key')) && array_key_exists($this->get('key'), $_SERVER);
    }

    public function hasValue()
    {
        return $this->hasKey() && !is_null($this->get('value')) && $this->get('value') == $_SERVER[$this->get('key')];
    }

    public function testValueWithRegex()
    {
        return $this->hasKey() && !is_null($this->get('regex')) && preg_match($this->get('regex'), $_SERVER[$this->get('key')]);
    }

}
