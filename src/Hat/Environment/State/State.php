<?php
namespace Hat\Environment\State;

class State
{
    const INIT = 'init';

    const OK = 'ok';

    const FAIL = 'fail';

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
        return in_array($this->state, (array)$state);
    }


    public function isFail()
    {
        return $this->isState(self::FAIL);
    }

    public function isOk()
    {
        return $this->isState(self::OK);
    }


}
