<?php

namespace Environment;

class Profile extends Holder
{


    public function getDefinitions()
    {
        $result = array();

        foreach ($this->getData() as $name => $value) {

            $definition = new Definition($name, $value);

            if($definition->isValid())
            {
                $result[$name] = $definition;
            }
        }


        return $result;
    }

    public function extendsProfile(Profile $profile)
    {

    }

}
