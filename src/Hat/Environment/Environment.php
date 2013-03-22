<?php
namespace Hat\Environment;

use Hat\Environment\Kit\Kit;

class Environment
{

    /**
     * @var Kit
     */
    protected $kit;

    public function __construct(Kit $kit = null)
    {
        if (!$kit) {
            $kit = $this->createKit();
        }

        $this->kit = $kit;
    }

    public function __invoke(Request $request = null)
    {
        return $this->handle($request);
    }

    public function handle(Request $request = null)
    {
        if ($request) {
             $this->kit->set('request', $request);
        }

        return $this->kit->get('request.handler')->handle($this->kit->get('request'));
    }

    /**
     * @return Kit
     */
    protected function createKit()
    {
        return new Kit(require 'Environment.config.php');
    }

}
