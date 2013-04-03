<?php
namespace Hat\Environment;

class HolderIterator extends \ArrayIterator
{

    /**
     * @var Holder
     */
    protected $holder;

    public function __construct(Holder $holder)
    {
        $this->holder = $holder;
        parent::__construct($holder->getData());
    }

    public function offsetGet($index)
    {
        return $this->holder->get($index);
    }

    public function current()
    {
        return $this->holder->get($this->key());
    }


}
