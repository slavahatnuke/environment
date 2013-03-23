<?php
namespace Hat\Environment\State;

class State
{
    const INIT = 'init';

    const HANDLING = 'handling';

    const OK = 'ok';

    const FAIL = 'fail';

    const SKIP = 'skip';

    protected $state = self::INIT;

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function isState($state)
    {
        return $this->state == $state;
    }

}
