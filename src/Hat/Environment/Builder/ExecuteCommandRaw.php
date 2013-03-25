<?php
namespace Hat\Environment\Builder;


use Hat\Environment\TesterOutput;

class ExecuteCommandRaw extends Builder
{
    protected $defaults = array(
        'command' => null,
    );

    public function build()
    {
        //TODO [extract][cli][component] extract to CLI component
        echo "\n";
        echo "        ";
        echo $command = $this->get('command');
        echo "\n";

        passthru($command, $return);

        return $return == 0;
    }
}
