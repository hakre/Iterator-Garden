<?php
/**
 * Iterator Garden
 */

class DisabledIteratorTest extends IteratorTestCase
{
    public function testConstructor()
    {
        $it       = new ArrayIterator(range('a', 'c'));
        $disabled = new DisabledIterator($it);

        $this->assertInstanceOf('DisabledIterator', $disabled);
    }

    public function testDisabling()
    {
        $it       = new ArrayIterator(range('a', 'c'));
        $disabled = new DisabledIterator($it);

        $this->assertTrue($disabled->valid());

        // invalidate inner iterator first because ArrayIterator is valid() even un-initialized
        iterator_count($it);
        $this->assertFalse($disabled->valid());

        $disabled->rewind();
        $this->assertFalse($disabled->valid());
        $it->rewind();
        $this->assertTrue($it->valid());
        $this->assertTrue($disabled->valid());

        $disabled->next();
        $disabled->next();
        $disabled->next();
        $this->assertTrue($disabled->valid());
    }
}
