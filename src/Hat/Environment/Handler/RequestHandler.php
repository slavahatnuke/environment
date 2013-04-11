<?php
namespace Hat\Environment\Handler;

use Hat\Environment\Request\Request;

use Hat\Environment\Output\Output;
use Hat\Environment\Output\Message\StatusLineMessage;

use Hat\Environment\Exception;
use Hat\Environment\State\State;

class RequestHandler extends CompositeHandler
{
    /**
     * @var \Hat\Environment\Output\Output
     */
    protected $output;

    public function __construct(Output $output)
    {
        $this->output = $output;
    }


    public function supports($data)
    {
        return $data instanceof Request;
    }

    protected function doHandle($request)
    {
        try {
            $result = parent::doHandle($request);

            if ($result) {
                $this->output->write(new StatusLineMessage(State::OK, $request->get('profile')));
                exit(0);
            } else {
                $this->output->write(new StatusLineMessage(State::FAIL, $request->get('profile')));
                exit(1);
            }


        } catch (Exception $e) {

            $message = $e->getMessage();
            $message .= "\n";

            $message .= $e->getFile();
            $message .= ":";
            $message .= $e->getLine();

            $this->output->write(new StatusLineMessage(State::EXCEPTION, $message));

            exit(2);
        }

    }

}
