<?php
namespace Hat\Environment;

class Handler
{
    public function handle($data)
    {
        if ($this->supports($data)) {
            return $this->doHandle($data);
        } else {
            throw new Exception('Can not handle not supportable data');
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
