<?php
namespace Hat\Environment\Tests\Kit;

use Hat\Environment\Kit\Kit;

use Mockery as M;

class ServiceTest extends \PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        M::close();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function shouldExtendsHolder()
    {
        $this->assertTrue(new Kit() instanceof \Hat\Environment\Holder);
    }

    /**
     * @test
     */
    public function shouldUnwrapService()
    {
        $service = M::mock('Hat\Environment\Kit\Service');
        $kit = new Kit(array('service' => $service));

        $expected = 'xxx';

        $service->shouldReceive('__invoke')->once()->with($kit)->andReturn($expected);

        $result = $kit->get('service');

        $this->assertSame($expected, $result);

        $result = $kit->get('service');
        $this->assertSame($expected, $result);

    }


}
