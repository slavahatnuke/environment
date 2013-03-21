<?php
namespace Hat\Environment\Tests;

use Hat\Environment\Environment;

use Mockery as M;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    protected $env;

    protected function setUp()
    {
        $this->env = new Environment();
        parent::setUp();
    }

    protected function tearDown()
    {
        M::close();
        parent::tearDown();
    }


    /**
     * @test
     */
    public function shouldAllowToCreateInstance()
    {
        $this->assertTrue($this->env instanceof Environment);
    }
}
