<?php
namespace Hat\Environment\Tests\Kit;

use Hat\Environment\Kit\Kit;
use Hat\Environment\Kit\Service;
use Hat\Environment\Kit\Factory;


use Mockery as M;

class KitTest extends \PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        M::close();
        parent::tearDown();
    }


    /**
     * @test
     */
    public function shouldUnwrapResult()
    {

        $expected = 'result';

        $service = new Service(function(Kit $kit) use ($expected){
            return $expected;
        });

        $kit = M::mock('Hat\Environment\Kit\Kit');
        $result = $service($kit);


        $this->assertSame($expected, $result);

    }

    /**
     * @test
     */
    public function factoryIsSubInstanceOfService()
    {
        $this->assertTrue(new Factory(function(){}) instanceof Service);
    }
}
