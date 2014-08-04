<?php
/**
 * Iterator Garden
 */

/**
 * @covers DualDirectoryIterator
 */
class DualDirectoryIteratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function creation() {
        $dual = new DualDirectoryIterator('.', '.');
        $this->assertInstanceOf('DualDirectoryIterator', $dual);
    }

    /**
     * @test
     */
    public function creationWithFilesystemIterator() {
        $iter = new FilesystemIterator('.');
        $dual = new DualDirectoryIterator($iter, '.');
        $this->assertInstanceOf('DualDirectoryIterator', $dual);
    }

    /**
     * @test
     * @expectedException LogicException
     */
    public function unrewound() {
        $dual = new DualDirectoryIterator('.', '.');
        $dual->current(); // current() w/o rewind()
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     */
    public function invalidFileInfoClass() {
        $dual = new DualDirectoryIterator('.', '.');

        $this->addToAssertionCount(1);
        try {
            $dual->setInfoClass(null);
        } catch(Exception $e) {
            $this->fail('Exception on NULL is wrong');
        }

        $dual->setInfoClass('IteratorIterator');
    }

    /**
     * @test
     */
    public function fileInfoClass() {
        $dual = new DualDirectoryIterator('.', '.');

        $infoClass = 'FilesystemStubIterator';
        $dual->setInfoClass($infoClass);

        $dual->rewind();
        $first = $dual->current();
        $this->assertInstanceOf($infoClass, $first);

        list($a, $b) = $dual->getFileInfos();
        $this->assertInstanceOf($infoClass, $a);
        $this->assertInstanceOf($infoClass, $b);
        $this->assertEquals($a, $b);
    }
}
