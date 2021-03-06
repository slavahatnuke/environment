<?php
namespace Hat\Environment\Output\Message;

use Hat\Environment\State\DefinitionState;
use Hat\Environment\State\State;

class StatusLineMessage extends Message
{
    protected $status;

    protected $message;

    protected $status_length = 12;

    public function __construct($status, $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function render()
    {
        $status = "[{$this->status}]";

        $status = str_pad($status, $this->status_length);
        $status = strtoupper($status);

        return "{$status}{$this->message}\n";
    }

}
