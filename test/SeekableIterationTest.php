<?php
/**
 * Iterator Garden
 */

/**
 * @covers SeekableIteration
 */
class SeekableIterationTest extends IteratorTestCase
{

    public function testConstructor()
    {
        $it = new SeekableIteration(new EmptyIterator());
        $this->assertInstanceOf('SeekableIteration', $it);
    }

    /**
     * @test
     */
    public function seekStartWorksForRewind()
    {
        $it = new SeekableIteration(new RangeIterator(0, 4));
        $it->seekStart(2);
        foreach ($it as $value) {
            $this->assertEquals(2, $value);
            break;
        }
    }

    /**
     * @test
     * @covers SeekableIteration::seek
     */
    public function rewindOnSeek()
    {
        $inner = $this->getMock('RangeIterator', array('rewind'), array(0, 4));
        $inner->expects($this->once())
            ->method('rewind');

        $it = new SeekableIteration($inner);
        $it->seek(2);
    }

    /**
     * @test
     * @covers SeekableIteration::seek
     * @expectedException InvalidArgumentException
     */
    public function exceptionOnInvalidSeekPosition()
    {
        $it = new SeekableIteration(new RangeIterator(0, 4));
        $it->seek(4);
        $it->seek(1);
    }
}
