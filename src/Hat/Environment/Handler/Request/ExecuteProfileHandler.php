<?php
namespace Hat\Environment\Handler\Request;

use Hat\Environment\Handler\Handler;

class ExecuteProfileHandler extends Handler
{
    protected $loader;

    protected $handler;

    public function __construct($loader, $handler)
    {
        $this->loader = $loader;
        $this->handler = $handler;
    }

    public function supports($request)
    {
        return $request->has('profile');
    }

    protected function doHandle($request)
    {
        return $this->handler->handle($this->loader->loadByPath($request->get('profile')));
    }

}
