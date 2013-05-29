<?php
namespace Hat\Environment\Builder;


use Hat\Environment\LimitedString;
use Hat\Environment\Output\Output;
use Hat\Environment\Output\Message\StatusLineMessage;
use Hat\Environment\Kit\Kit;

class ExecuteCommand extends Builder
{
    /**
     * @var Output
     */
    protected $output;

    protected $defaults = array(
        'command' => null,
    );

    public function setupServices(Kit $kit)
    {
        $this->output = $kit->get('output');
    }

    public function build()
    {

        $command = $this->get('command');
        $output = '';

        $this->output->write(new StatusLineMessage('execute', $command));

        exec($command, $output, $return);

        $this->set('output', new LimitedString($output));

        return $return == 0;
    }
}
