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
        $this->kit = $kit;
    }

    public function __invoke(Request $request = null)
    {
        return $this->handle($request);
    }

    public function handle(Request $request = null)
    {

        if ($request) {
            $this->getKit()->set('request', $request);
        }

        return $this->getKit()->get('request.handler')->handle($this->getKit()->get('request'));
    }


    /**
     * @return Kit
     */
    public function getKit()
    {
        if (!$this->kit) {
            $this->kit = $this->createKit();
        }
        return $this->kit;
    }

    /**
     * @return Kit
     */
    protected function createKit()
    {
        return new Kit(require 'Environment.config.php');
    }

}
