<?php
namespace Hat\Environment\Handler;

class PlainHandler extends CompositeHandler
{

    protected function doHandle($data)
    {

        $handled = false;

        foreach ($this->handlers as $handler) {
            if ($handler->supports($data)) {
                $handled = true;
                $handler->handle($data);
            }
        }

        if (!$handled) {
            throw new HandlerException('Can not be handled');
        }

    }

}
