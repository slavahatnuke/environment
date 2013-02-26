<?php
namespace Hat\Environment;

class Holder implements \IteratorAggregate
{

    protected $data = array();

    public function __construct($data = array())
    {
        if (is_array($data)) {
            $this->setData($data);
        }
    }

    public function has($name)
    {
        return array_key_exists($name, $this->data);
    }

    public function get($name)
    {
        return $this->has($name) ? $this->data[$name] : null;
    }

    public function set($name, $value)
    {
        return $this->data[$name] = $value;
    }

    public function add($value)
    {
        return $this->data[] = $value;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        return $this->data = $data;
    }

    public function apply($data)
    {
        if (is_array($data) || $data instanceof \Traversable) {
            foreach ($data as $name => $value) {
                if (is_array($this->get($name))) {
                    $holder = new self($this->get($name));
                    $holder->apply($value);
                    $value = $holder->getData();
                }
                $this->set($name, $value);
            }

        }
    }

    public function extend($data)
    {
        $holder = new self;
        $holder->apply($data);
        $holder->apply($this->getData());
        $this->setData($holder->getData());
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getData());
    }


}
