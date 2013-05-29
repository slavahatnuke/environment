<?php
namespace Hat\Environment\Builder;

use Hat\Environment\Output\Output;
use Hat\Environment\Output\Message\StatusLineMessage;
use Hat\Environment\Kit\Kit;

class ExecuteCommandRaw extends Builder
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

        $this->output->write(new StatusLineMessage('execute', $command));

        passthru($command, $return);

        return $return == 0;
    }
}
