<?php
namespace Hat\Environment\Tests;

use Hat\Environment\Environment;

use Mockery as M;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Environment
     */
    protected $env;


    /**
     * @var \Mockery\MockInterface
     */
    protected $request;

    /**
     * @var \Mockery\MockInterface
     */
    protected $kit;

    protected function setUp()
    {
        $this->kit = M::mock('Hat\Environment\Kit\Kit');
        $this->request = M::mock('Hat\Environment\Kit\Kit');
        $this->env = new Environment($this->kit);

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
    public function shouldAllowToHandleRequest()
    {

        $expected = 'result';

        $handler = M::mock('Hat\Environment\Request\Request;Handler');
        $request = M::mock('Hat\Environment\Request\Request;');

        $this->kit->shouldReceive('get')->once()->with('request.handler')->andReturn($handler);
        $this->kit->shouldReceive('get')->once()->with('request')->andReturn($request);
        $handler->shouldReceive('handle')->once()->with($request)->andReturn($expected);

        $result = $this->env->handle();

        $this->assertSame($result, $expected);
    }
}
