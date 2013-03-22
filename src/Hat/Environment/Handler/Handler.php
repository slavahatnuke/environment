<?php
namespace Hat\Environment\Handler;

class Handler
{

    public function handle($data)
    {
        if ($this->supports($data)) {
            return $this->doHandle($data);
        } else {
            throw new HandlerException('Can not handle not supportable data');
        }
    }

    protected function doHandle($data)
    {

    }

    public function supports($data)
    {
        return false;
    }
}
