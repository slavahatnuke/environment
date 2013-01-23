<?php

namespace Environment;

class Holder implements \IteratorAggregate
{

    static public function arrayMerge($a1, $a2)
    {
        foreach ($a2 as $k => $v) {

            if (is_array($a2[$k])) {
                $a1[$k] = self::arrayMerge($a1[$k], $a2[$k]);
            } else {
                $a1[$k] = $v;
            }

        }

        return $a1;

    }

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
            foreach ($data as $key => $value) {
                $this->set($key, $value);
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
