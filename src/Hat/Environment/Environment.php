<?php
namespace Hat\Environment;

class Environment
{

    public function __invoke(Request $request)
    {
        return $this->handle($request);
    }

    public function handle(Request $request)
    {
        $result = false;

        try {
            $result = $this->handleRequest($request);
        } catch (\Exception $e) {
            echo "\n";

            echo "[FAIL]  ";
            echo "Exception: ";
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

    protected function handleRequest(Request $request)
    {
        if (!count($request) || $request->get('help')) {
            echo file_get_contents(__DIR__ . '/HELP'), "\n";
            exit(0);
        }

        if (!$request->has('profile')) {
            throw new \Exception('--profile option is required');
        }

        if (!file_exists($request->get('profile'))) {
            throw new \Exception('No file: ' . $request->get('profile'));
        }

        return $this->test($request->get('profile'));
    }

    public function test($path)
    {
        $tester = new ProfileTester($path);

        return $tester->test();
    }
}
