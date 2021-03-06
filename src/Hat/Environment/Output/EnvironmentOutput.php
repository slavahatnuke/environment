<?php
namespace Hat\Environment\Output;

use Hat\Environment\State\DefinitionState;
use Hat\Environment\State\ProfileState;

use Hat\Environment\Output\Message\StatusLineMessage;
use Hat\Environment\Request\Request;

class EnvironmentOutput extends Output
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function write($message = '')
    {

        if ($this->request->has('verbose')) {
            return parent::write($message);
        }

        $states = array(
            DefinitionState::OK,
            DefinitionState::FAIL,
            DefinitionState::SKIP,
            DefinitionState::DOC,
            ProfileState::EXCEPTION,
            'execute',
//            ProfileState::HANDLE,
        );

        if ($message instanceof StatusLineMessage) {
            if (in_array($message->getStatus(), $states)) {
                return parent::write($message);
            } else {
                return;
            }
        }

        if (is_string($message)) {
            parent::write($message);
        }

    }
}
