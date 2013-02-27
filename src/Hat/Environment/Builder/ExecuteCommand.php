<?php
namespace Hat\Environment\Builder;

use Hat\Environment\Builder;
use Hat\Environment\TesterOutput;

class ExecuteCommand extends Builder
{
    protected $defaults = array(
        'command' => null,
    );

    public function build()
    {
        //TODO [extract][cli][component] extract to CLI component
        $command = $this->get('command');
        $output = '';
        exec($command, $output, $return);

        $this->set('output', new TesterOutput(join('', $output)));

        return $return == 0;
    }
}
