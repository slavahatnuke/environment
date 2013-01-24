<?php

namespace Environment;

class Profile extends Holder
{


    public function getDefinitions()
    {
        $result = array();

        foreach ($this->getData() as $name => $value) {
            $result[$name] = new Definition($name, $value);

        }


        return $result;
    }

}
