<?php
namespace Hat\Environment\Handler;

class PlainHandler extends CompositeHandler
{

    protected $strict_handler = true;

    protected function doHandle($data)
    {

        $handled = false;

        foreach ($this->handlers as $handler) {
            if ($handler->supports($data)) {
                $handled = true;
                $handler->handle($data);
            }
        }

        if ($this->strict_handler && !$handled) {
            throw new HandlerException('Can not be handled');
        }

    }

}
