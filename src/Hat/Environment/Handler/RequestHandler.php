<?php
namespace Hat\Environment\Handler;

use Hat\Environment\Request\Request;
use Hat\Environment\Handler\HandlerException;

class RequestHandler extends CompositeHandler
{

    public function supports($data)
    {
        return $data instanceof Request;
    }

    protected function doHandle($request)
    {
        try {
            $result = parent::doHandle($request);

            if ($result) {
                exit(0);
            } else {
                exit(1);
            }


        } catch (HandlerException $e) {
            echo "\n";

            echo "[FAIL]  ";
            echo "HandlerException: ";
            echo $e->getMessage();
            echo "\n";
            echo $e->getFile();
            echo ":";
            echo $e->getLine();

            echo "\n";
            echo "\n";

            exit(2);
        }

    }

}
