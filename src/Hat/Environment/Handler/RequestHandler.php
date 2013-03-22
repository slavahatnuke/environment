<?php
namespace Hat\Environment\Handler;

use Hat\Environment\Request;

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


        echo "\n";

        echo $result ? "[OK]    " : "[FAIL]  ";

        if ($result) {
            echo "Test(s) passed";
            echo "\n";
            echo "\n";
            exit(0);
        } else {
            echo "Test(s) failed";
            echo "\n";
            echo "\n";
            exit(1);
        }

    }

}
