<?php
namespace Hat\Environment\Tester;


use Hat\Environment\LimitedString;

class FileContains extends Tester
{
    protected $defaults = array(
        'file' => 'path to file',
        'contains' => null,
        'regex' => null,
    );

    public function test()
    {

        $file = $this->get('file');

        if (!(is_readable($file) && file_exists($file))) {
            $this->set('output', new LimitedString('can not read file: ' . $file));

            return false;
        }

        $text = file_get_contents($file);

        $this->set('output', new LimitedString($text));

        return $this->testExpected($text) || $this->testRegex($text);
    }


    public function testExpected($text)
    {
        return !is_null($this->get('contains')) && strpos(
            strtolower($text),
            strtolower($this->get('contains'))
        ) !== false;
    }

    public function testRegex($text)
    {
        return !is_null($this->get('regex')) && preg_match($this->get('regex'), $text);
    }

}
