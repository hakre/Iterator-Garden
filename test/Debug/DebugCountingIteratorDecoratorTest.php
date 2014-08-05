<?php
/*
 * Iterator Garden
 */

class DebugCountingIteratorDecoratorTest extends IteratorTestCase
{
    /**
     * @test
     */
    public function canInstantiate() {
        $it = new DebugCountingIteratorDecorator(new EmptyIterator());
    }

    /**
     * @test
     */
    public function countRewinds() {
        $it = new DebugCountingIteratorDecorator(new EmptyIterator());
        $this->assertNull($it->getRewindCount());
        $it->rewind();
        $this->assertEquals(1, $it->getRewindCount());
    }
}
