<?php
namespace Hat\Environment\Tests\Builder;

use org\bovigo\vfs;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var vfs\vfsStreamDirectory
     */
    private $root;

    /**
     * @var \Hat\Environment\Builder\Delete
     */
    private $deleteBuilder;

    public function setUp()
    {
        $this->root = vfs\vfsStream::setup(
            'root',
            null,
            array(
                'workDir' => array(
                    'file' => 'some text',
                    'emptyDir' => array(),
                    'keepDir' => array(
                        '.sf' => '',
                    )
                )
            )
        );
        $this->deleteBuilder = $this->getMock(
            'Hat\Environment\Builder\Delete',
            array('get')
        );

    }

    protected function params($path, $exclude = null)
    {
        $map = array(
            array('path', $path),
        );
        if ($exclude) {
            $map[] = array('exclude', $exclude);
        }
        $this->deleteBuilder->expects($this->any())
            ->method('get')
            ->withAnyParameters()
            ->will(
                $this->returnValueMap($map)
            );
    }

    /**
     * @test
     */
    public function emptyDirectoryAndAllFilesMustBeDeleted()
    {
        $this->params($this->root->getChild('workDir')->url(), null);
        $this->assertTrue($this->deleteBuilder->build());
        $this->assertFalse($this->root->hasChild('workDir'));
    }

    /**
     * @test
     */
    public function excludeFilesMustNotBeDeleted()
    {
        $this->params($this->root->getChild('workDir')->url(), '.sf');
        $this->assertTrue($this->deleteBuilder->build());
        $this->assertTrue($this->root->hasChild('workDir'));
        $this->assertTrue($this->root->getChild('workDir')->hasChild('keepDir'));
        $this->assertTrue($this->root->getChild('workDir')->getChild('keepDir')->hasChild('.sf'));
    }
}
