<?php
/**
 * Iterator Garden
 */

class DebugFilterIteratorTest extends IteratorTestCase
{
    public function setUp()
    {
        $this->inner    = new ArrayIterator(range('a', 'c'));
        $this->iterator = new DebugFilterIterator($this->inner);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('DebugFilterIterator', $this->iterator);
    }

    public function testIteration() {
        $actual = iterator_count($this->iterator);
        $this->assertSame(3, $actual);
    }

    public function TODO_testFilter()
    {
        $array = range('a', 'c');
        $inner = $this->getMock('ArrayIterator', NULL, array($array));
        $inner->expects($this->exactly(3))
            ->method('current()')
            ->will($this->returnValueMap($array));

        $stub = $this->getMockBuilder('DebugFilterIterator')
            ->setConstructorArgs(array($inner))
            ->getMock();

        $stub->expects($this->any())
            ->method('accept')
            ->will($this->returnValue(TRUE));

        var_dump($stub->accept());

        $this->assertSame(3, iterator_count($stub));
    }

    /**
     * just a test with a collaborating mock iterator object.
     */
    public function testMockInner() {
        $array = range('a', 'c');
        $inner = $this->getMock('ArrayIterator', array('current'), array($array));
        $inner->expects($this->exactly(3))
            ->method('current')
            ->will($this->onConsecutiveCallsArray($array));

        $inner = DebugIteratorEmitter::createFor($inner)->registerOutput()->getDebugIterator();

        $count = iterator_count($inner);
        $this->assertEquals(3, $count);

        $copy = iterator_to_array($inner, FALSE);
        $this->assertCount(3, $copy);
    }

    private function onConsecutiveCallsArray(array $stack) {
        return new PHPUnit_Framework_MockObject_Stub_ConsecutiveCalls($stack);
    }
}
