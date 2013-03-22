<?php
namespace Hat\Environment\Kit;

use Hat\Environment\Holder;

class Kit extends Holder
{
    public function get($name)
    {
        $value = parent::get($name);

        if ($value instanceof Service) {
            $service = $value($this);
            $this->set($name, $service);

            return $this->get($name);
        }

        return $value;
    }

}
