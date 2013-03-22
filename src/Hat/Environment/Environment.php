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
            $kit = $this->loadKit();
        }

        $this->kit = $kit;
    }

    /**
     * @return Kit
     */
    protected function loadKit()
    {
        return new Kit(require 'Environment.config.php');
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

}
