<?php
namespace Hat\Environment\Builder;


use Hat\Environment\TesterOutput;

class ChangeDir extends Builder
{
    protected $defaults = array(
        'dir' => null,
    );

    public function build()
    {
        //TODO [extract][cli][component] extract to CLI component
        echo "\n";
        echo "        ";
        echo "dir: ";
        echo $dir = $this->get('dir');
        echo "\n";


        if(is_dir($dir))
        {
            chdir($dir);
            return true;
        }

        $this->set('output', new TesterOutput('dir: ' . $dir));

        return false;
    }
}
