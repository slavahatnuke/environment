<?php
namespace Hat\Environment\Handler\Request;

use Hat\Environment\Handler\Handler;

class DefineProfileHandler extends Handler
{

    public function supports($request)
    {
        return $request->has('parameters')
            && count($request->get('parameters')) > 1;
    }

    protected function doHandle($request)
    {
        $parameters = $request->get('parameters');
        $request->set('profile', $parameters[0]);
        return $request;
    }

}
