<?php
namespace Hat\Environment\Builder;


use Hat\Environment\LimitedString;

class ExecuteCommand extends Builder
{
    protected $defaults = array(
        'command' => null,
    );

    public function build()
    {
        //TODO [extract][cli][component] extract to CLI component
        echo "\n";
        echo "            ";
        echo $command = $this->get('command');
        echo "\n";
        echo "\n";
        $output = '';

        exec($command, $output, $return);

        $this->set('output', new LimitedString($output));

        return $return == 0;
    }
}
