<?php

namespace Environment;

class Environment
{

    public function __invoke(Request $request)
    {
        return $this->handle($request);
    }

    public function handle(Request $request)
    {
        if(!$request->has('profile'))
        {
            throw new \Exception('--profile option is required');
        }

        if(!file_exists($request->get('profile')))
        {
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
